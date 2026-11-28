<?php

use App\Http\Controllers\ReportsController;
use App\Models\Device;
use App\Models\PcAccessLogs;
use App\Models\User;
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

it('generates a real PDF stream for the access log report', function () {
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

    expect($response->headers->get('Content-Type'))
        ->toContain('application/pdf')
        ->and(substr($response->getContent(), 0, 5))
        ->toBe('%PDF-');
});

it('generates a real PDF stream for the student summary report', function () {
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

    expect($response->headers->get('Content-Type'))
        ->toContain('application/pdf')
        ->and(substr($response->getContent(), 0, 5))
        ->toBe('%PDF-');
});

it('repeats the institutional header and footer on every access log page', function () {
    $device = pdfReportDevice();

    foreach (range(1, 25) as $index) {
        pdfReportLog($device, [
            'student_name' => sprintf('Student %02d', $index),
        ]);
    }

    $logs = PcAccessLogs::query()->orderBy('occurred_at')->get();
    $pages = pdfReportPages($logs, 16, 20);

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
        ->and(substr_count($html, 'QS Stars Rated Good'))->toBe(2)
        ->and(substr_count($html, 'Page 1 of 2'))->toBe(1)
        ->and(substr_count($html, 'Page 2 of 2'))->toBe(1)
        ->and(substr_count($html, 'page-break-after: always'))->toBe(1);
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
    $pages = pdfReportPages($students, 12, 22);

    $html = view('admin.reports.SummaryReport.pdf', [
        'students' => $students,
        'pages' => $pages,
        'filters' => [],
        'periodLabel' => 'All Time',
        'generatedAt' => now(),
    ])->render();

    expect($pages)->toHaveCount(2)
        ->and(substr_count($html, 'Excellence | Service | Leadership and Good Governance'))->toBe(2)
        ->and(substr_count($html, 'QS Stars Rated Good'))->toBe(2)
        ->and(substr_count($html, 'Page 1 of 2'))->toBe(1)
        ->and(substr_count($html, 'Page 2 of 2'))->toBe(1)
        ->and(substr_count($html, 'page-break-after: always'))->toBe(1)
        ->and($html)->not->toContain('>Sessions<')
        ->and($html)->not->toContain('>Computers<')
        ->and($html)->not->toContain('Top Workstation');
});
