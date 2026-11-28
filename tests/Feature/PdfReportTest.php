<?php

use App\Http\Controllers\ReportsController;
use App\Models\Device;
use App\Models\PcAccessLogs;
use App\Models\User;
use App\Services\ReportCharts;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function pdfReportDevice(): Device
{
    return sessionTestDevice([
        'workstation_name' => 'PDF-PC-01',
        'api_token' => 'pdf-token',
    ]);
}

function pdfReportLog(Device $device, array $attributes = []): PcAccessLogs
{
    return PcAccessLogs::create(array_merge([
        'occurred_at' => now(),
        'received_at' => now(),
        'rfid_uid' => 'PDF-'.uniqid(),
        'device_id' => $device->id,
        'event_type' => 'time_in',
        'result' => 'allowed',
        'reason' => 'Authorized',
        'session_id' => 'pdf-ses-'.uniqid(),
        'student_external_id' => '2026-0001',
        'student_name' => 'Dela Cruz, Juan',
        'course' => 'BSIT',
    ], $attributes));
}

function pdfReportPages($rows, int $firstPageSize, int $pageSize): array
{
    $method = new ReflectionMethod(ReportsController::class, 'paginateReportRows');

    return $method->invoke(new ReportsController, collect($rows), $firstPageSize, $pageSize);
}

function expectPortraitA4Pdf(string $pdf): void
{
    expect(preg_match('~/MediaBox\s*\[\s*0(?:\.0+)?\s+0(?:\.0+)?\s+595\.28\d*\s+841\.89\d*\s*\]~', $pdf))->toBe(1)
        ->and($pdf)->toContain('Aptos')
        ->and($pdf)->not->toContain('DejaVu');
}

it('generates a real portrait A4 PDF stream for the access log report', function () {
    $device = pdfReportDevice();

    foreach (range(1, 25) as $index) {
        pdfReportLog($device, [
            'student_name' => sprintf('Student %02d', $index),
        ]);
    }

    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('reports.accesslog.pdf', ['range' => 'all']));

    $response->assertOk();

    $pdf = $response->getContent();

    expect($response->headers->get('Content-Type'))
        ->toContain('application/pdf')
        ->and(substr($pdf, 0, 5))
        ->toBe('%PDF-');

    expectPortraitA4Pdf($pdf);
});

it('generates a real portrait A4 PDF stream with an embedded chart for the student summary report', function () {
    $device = pdfReportDevice();

    foreach (range(1, 15) as $index) {
        pdfReportLog($device, [
            'student_external_id' => sprintf('2026-%04d', $index),
            'student_name' => sprintf('Student %02d', $index),
        ]);
    }

    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('reports.summary.pdf', ['range' => 'all']));

    $response->assertOk();

    $pdf = $response->getContent();

    expect($response->headers->get('Content-Type'))
        ->toContain('application/pdf')
        ->and(substr($pdf, 0, 5))
        ->toBe('%PDF-');

    expectPortraitA4Pdf($pdf);

    expect(preg_match('~/Width\s+360\s*/Height\s+360~', $pdf))->toBe(1);
});

it('generates a PNG donut image for the course distribution chart', function () {
    $image = app(ReportCharts::class)->donut(
        [2, 1],
        ['BSIT', 'BSBA'],
        ['#2563EB', '#0EA5E9'],
        3
    );

    expect($image)->toStartWith('data:image/png;base64,');

    $png = base64_decode(substr($image, strlen('data:image/png;base64,')));

    expect(substr($png, 0, 8))->toBe("\x89PNG\r\n\x1a\n");
});

it('uses a varied course chart palette for both report views', function () {
    $method = new ReflectionMethod(ReportsController::class, 'studentSummaryAnalytics');

    $analytics = $method->invoke(new ReportsController, ['all_time' => true]);

    expect($analytics['chartCourseColors'])->toBe([
        '#2563EB', '#0EA5E9', '#10B981', '#F59E0B', '#8B5CF6', '#94A3B8',
    ]);
});

it('repeats the institutional header and footer on every access log page', function () {
    $device = pdfReportDevice();

    foreach (range(1, 25) as $index) {
        pdfReportLog($device, [
            'student_name' => sprintf('Student %02d', $index),
        ]);
    }

    $logs = PcAccessLogs::query()->orderBy('occurred_at')->get();
    $pages = pdfReportPages($logs, 16, 19);

    $html = view('admin.reports.AccessLogReport.pdf', [
        'logs' => $logs,
        'pages' => $pages,
        'columns' => [
            'student_name' => true,
            'course' => true,
            'device' => true,
            'date_time' => true,
            'event' => true,
        ],
        'filters' => [],
        'generatedAt' => now(),
    ])->render();

    expect($pages)->toHaveCount(2)
        ->and(substr_count($html, 'Excellence | Service | Leadership and Good Governance'))->toBe(2)
        ->and(substr_count($html, 'Page 1 of 2'))->toBe(1)
        ->and(substr_count($html, 'Page 2 of 2'))->toBe(1)
        ->and(substr_count($html, 'page-break-after: always'))->toBe(1)
        ->and(substr_count($html, 'class="page-header"'))->toBe(2)
        ->and(substr_count($html, 'class="page-footer"'))->toBe(2)
        ->and(substr_count($html, 'class="slsu-logo"'))->toBe(2)
        ->and(substr_count($html, 'class="bagong-pilipinas-logo"'))->toBe(2)
        ->and(substr_count($html, 'class="qs-logo"'))->toBe(2)
        ->and(substr_count($html, 'class="socotec-logo"'))->toBe(2)
        ->and(substr_count($html, 'border-spacing: 18px 0;'))->toBe(2)
        ->and(substr_count($html, 'padding-top: 0;'))->toBe(2)
        ->and(substr_count($html, 'margin-bottom: 0;'))->toBe(2)
        ->and(substr_count($html, 'padding-bottom: 2px;'))->toBe(2)
        ->and(substr_count($html, 'class="olh-footer-cell olh-footer-page"'))->toBe(2)
        ->and($html)->toContain('padding-top: 8px;')
        ->and($html)->toContain('height: 90px;')
        ->and($html)->toContain('height: 70px;')
        ->and($html)->toContain('top: -8px;')
        ->and($html)->toContain('line-height: 1;')
        ->and(substr_count($html, 'top: -8px;'))->toBe(4)
        ->and($html)->toContain('height: 55px;')
        ->and($html)->toContain('height: 50px;')
        ->and($html)->toContain('bottom: 0;')
        ->and($html)->toContain('height: 1074px;')
        ->and($html)->toContain('padding-top: 130px;')
        ->and($html)->toContain('padding-left: 12.7mm;')
        ->and($html)->toContain('padding-right: 12.7mm;')
        ->and(substr_count($html, 'width: 86%;'))->toBe(4)
        ->and($html)->not->toContain('bottom: 78px;')
        ->and($html)->toContain('margin-top: 3px;')
        ->and($html)->toContain('line-height: 1.35;')
        ->and(substr_count($html, 'class="page-note"'))->toBe(1)
        ->and($html)->toContain('This document was generated automatically by the Workstation Access Control System.')
        ->and($html)->not->toContain('Access records shown reflect the filters')
        ->and($html)->toContain('Workstation Access Control System')
        ->and($html)->not->toContain('OLH Library Management System');
});

it('repeats the institutional header and footer on every student summary page', function () {
    $device = pdfReportDevice();

    foreach (range(1, 15) as $index) {
        pdfReportLog($device, [
            'student_external_id' => sprintf('2026-%04d', $index),
            'student_name' => sprintf('Student %02d', $index),
        ]);
    }

    $students = collect(range(1, 15))->map(fn (int $index) => (object) [
        'student_external_id' => sprintf('2026-%04d', $index),
        'student_name' => sprintf('Student %02d', $index),
        'course' => 'BSIT',
        'allowed_accesses' => 1,
        'usage_seconds' => 3600,
        'first_access' => now(),
        'last_access' => now(),
    ]);
    $pages = pdfReportPages($students, 8, 16);

    $html = view('admin.reports.SummaryReport.pdf', [
        'students' => $students,
        'pages' => $pages,
        'filters' => [],
        'periodLabel' => 'All Time',
        'donutImage' => app(ReportCharts::class)->donut(
            [5, 4, 3, 2, 1],
            ['BSIT', 'BSBA', 'BEEd', 'BSTM', 'Other courses'],
            ['#2563EB', '#0EA5E9', '#10B981', '#F59E0B', '#8B5CF6'],
            15
        ),
        'chartCourseCounts' => [5, 4, 3, 2, 1],
        'chartCourseLabels' => ['BSIT', 'BSBA', 'BEEd', 'BSTM', 'Other courses'],
        'chartCourseColors' => ['#2563EB', '#0EA5E9', '#10B981', '#F59E0B', '#8B5CF6'],
        'chartCoursePercentages' => [33.3, 26.7, 20, 13.3, 6.7],
        'topStudentsByLogins' => collect([
            (object) ['student_name' => 'Student 01', 'login_count' => 10],
        ]),
        'topStudentsByTime' => collect([
            (object) ['student_name' => 'Student 01', 'total_seconds' => 3600, 'formatted_time' => '1h 0m'],
        ]),
        'topCoursesByLogins' => collect([
            (object) ['course' => 'BSIT', 'login_count' => 15],
        ]),
        'topCoursesByTime' => collect([
            (object) ['course' => 'BSIT', 'total_seconds' => 5400, 'formatted_time' => '1h 30m'],
        ]),
        'generatedAt' => now(),
    ])->render();

    expect($pages)->toHaveCount(2)
        ->and(substr_count($html, 'Excellence | Service | Leadership and Good Governance'))->toBe(2)
        ->and(substr_count($html, 'Page 1 of 2'))->toBe(1)
        ->and(substr_count($html, 'Page 2 of 2'))->toBe(1)
        ->and(substr_count($html, 'page-break-after: always'))->toBe(1)
        ->and(substr_count($html, 'class="page-header"'))->toBe(2)
        ->and(substr_count($html, 'class="page-footer"'))->toBe(2)
        ->and(substr_count($html, 'class="slsu-logo"'))->toBe(2)
        ->and(substr_count($html, 'class="bagong-pilipinas-logo"'))->toBe(2)
        ->and(substr_count($html, 'border-spacing: 18px 0;'))->toBe(2)
        ->and(substr_count($html, 'padding-top: 0;'))->toBe(2)
        ->and(substr_count($html, 'margin-bottom: 0;'))->toBe(2)
        ->and(substr_count($html, 'padding-bottom: 2px;'))->toBe(2)
        ->and(substr_count($html, 'class="olh-footer-cell olh-footer-page"'))->toBe(2)
        ->and($html)->toContain('padding-top: 8px;')
        ->and($html)->toContain('height: 90px;')
        ->and($html)->toContain('height: 70px;')
        ->and($html)->toContain('top: -8px;')
        ->and($html)->toContain('line-height: 1;')
        ->and(substr_count($html, 'top: -8px;'))->toBe(4)
        ->and($html)->toContain('bottom: 0;')
        ->and($html)->toContain('height: 1074px;')
        ->and($html)->toContain('padding-top: 130px;')
        ->and($html)->toContain('padding-left: 12.7mm;')
        ->and($html)->toContain('padding-right: 12.7mm;')
        ->and(substr_count($html, 'width: 86%;'))->toBe(4)
        ->and($html)->not->toContain('bottom: 78px;')
        ->and($html)->toContain('margin-top: 3px;')
        ->and($html)->toContain('line-height: 1.35;')
        ->and(substr_count($html, 'class="page-note"'))->toBe(1)
        ->and($html)->toContain('This document was generated automatically by the Workstation Access Control System.')
        ->and($html)->toContain('Workstation Access Control System')
        ->and($html)->not->toContain('OLH Library Management System')
        ->and($html)->toContain('class="donut-image" src="data:image/png;base64,')
        ->and($html)->toContain('padding: 0 0 6px;')
        ->and($html)->toContain('height: 120px;')
        ->and($html)->toContain('width: 120px;')
        ->and($html)->toContain('class="legend-box"')
        ->and($html)->toContain('line-height: 1.45;')
        ->and($html)->toContain('width: 52px;')
        ->and($html)->toContain('border-radius: 50%;')
        ->and($html)->toContain('vertical-align: middle;')
        ->and($html)->toContain('style="background-color: #2563EB;"')
        ->and($html)->toContain('style="background-color: #0EA5E9;"')
        ->and($html)->toContain('style="background-color: #10B981;"')
        ->and(substr_count($html, 'class="lb-rank"'))->toBe(4)
        ->and(substr_count($html, 'class="name-cell lb-name'))->toBe(4)
        ->and(substr_count($html, 'class="val-pill lb-value'))->toBe(4)
        ->and($html)->toContain('width: 10px;')
        ->and($html)->toContain('width: 52%;')
        ->and($html)->toContain('width: 34px;')
        ->and(substr_count($html, '· Allowed'))->toBe(2)
        ->and($html)->not->toContain('· Logins')
        ->and($html)->not->toContain('style="width: 14px;"')
        ->and($html)->not->toContain('>Sessions<')
        ->and($html)->not->toContain('>Computers<')
        ->and($html)->not->toContain('Top Workstation');
});
