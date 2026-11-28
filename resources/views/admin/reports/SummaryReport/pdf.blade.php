<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { box-sizing: border-box; }

        body {
            background: #ffffff;
            color: #1e293b;
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }

        .report-header {
            border-bottom: 2px solid #2563eb;
            margin-bottom: 10px;
            padding-bottom: 7px;
        }

        .label {
            color: #2563eb;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: .9px;
            text-transform: uppercase;
        }

        h1 {
            color: #0f172a;
            font-size: 16px;
            margin: 3px 0;
        }

        .description {
            color: #64748b;
            font-size: 8.5px;
        }

        .summary {
            border-collapse: separate;
            border-spacing: 5px 0;
            margin-bottom: 12px;
            table-layout: fixed;
            width: 100%;
        }

        .summary td {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 6px 9px;
            text-align: center;
            width: 33.33%;
        }

        .summary-label {
            color: #64748b;
            display: block;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .summary-value {
            color: #0f172a;
            display: block;
            font-size: 10px;
            font-weight: bold;
            margin-top: 2px;
        }

        .analytics-wrapper {
            margin-bottom: 12px;
            page-break-inside: avoid;
            width: 100%;
        }

        .analytics-table {
            border-collapse: separate;
            border-spacing: 8px 0;
            table-layout: fixed;
            width: 100%;
        }

        .analytics-col {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 8px;
            vertical-align: top;
        }

        .col-left { width: 44%; }
        .col-right { width: 56%; }

        .section-title {
            border-bottom: 1px solid #e2e8f0;
            color: #1e3a8a;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: .4px;
            margin: 0 0 6px 0;
            padding-bottom: 4px;
            text-transform: uppercase;
        }

        .donut-layout,
        .legend-table,
        .lb-grid,
        .lb-list {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }

        .donut-cell {
            text-align: center;
            vertical-align: middle;
            width: 108px;
        }

        .legend-cell {
            padding-left: 4px;
            vertical-align: middle;
        }

        .legend-row td {
            font-size: 6.8px;
            padding: 2px 0;
            vertical-align: top;
        }

        .legend-dot-col {
            padding-right: 3px;
            width: 8px;
        }

        .legend-dot {
            display: inline-block;
            height: 6px;
            width: 6px;
        }

        .legend-course-col {
            color: #334155;
            font-weight: bold;
        }

        .legend-count-col {
            color: #0f172a;
            font-weight: bold;
            text-align: right;
            white-space: nowrap;
        }

        .lb-grid {
            border-collapse: separate;
            border-spacing: 5px;
        }

        .lb-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 5px 6px;
            vertical-align: top;
            width: 50%;
        }

        .lb-title {
            border-bottom: 1px solid #cbd5e1;
            color: #0f172a;
            font-size: 7.2px;
            font-weight: bold;
            margin-bottom: 4px;
            padding-bottom: 3px;
        }

        .lb-subtitle {
            color: #2563eb;
            font-size: 6.2px;
            font-weight: bold;
        }

        .lb-item td {
            border-bottom: 1px dotted #e2e8f0;
            font-size: 6.8px;
            padding: 2px 0;
        }

        .rank-badge {
            color: #0f172a;
            font-size: 6.5px;
            font-weight: bold;
        }

        .name-cell {
            color: #1e293b;
            font-weight: bold;
        }

        .val-pill {
            color: #1d4ed8;
            font-size: 6.2px;
            font-weight: bold;
            text-align: right;
            white-space: nowrap;
        }

        .val-emerald { color: #047857; }
        .val-purple { color: #6b21a8; }

        table.data-table {
            border-collapse: collapse;
            margin-top: 8px;
            table-layout: fixed;
            width: 100%;
        }

        table.data-table tr {
            page-break-inside: avoid;
        }

        .data-table th {
            background: #1e3a8a;
            border: 1px solid #1e3a8a;
            color: #ffffff;
            font-size: 7px;
            font-weight: bold;
            padding: 5px;
            text-align: left;
            text-transform: uppercase;
        }

        .data-table td {
            border: 1px solid #e2e8f0;
            font-size: 7.5px;
            padding: 4px 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .data-table tr:nth-child(even) { background: #f8fafc; }
        .number { text-align: center; width: 25px; }
        .student { font-weight: bold; }
        .muted { color: #64748b; }
        .empty { padding: 14px !important; text-align: center; }

        .note {
            color: #64748b;
            font-size: 7.5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    @php
        $pieCounts = $chartCourseCounts ?? [];
        $pieLabels = $chartCourseLabels ?? [];
        $pieColors = $chartCourseColors ?? ['#1d4ed8', '#2563eb', '#3b82f6', '#60a5fa', '#93c5fd', '#cbd5e1'];
        $piePercentages = $chartCoursePercentages ?? [];
        $pieTotal = array_sum($pieCounts);

        $size = 104;
        $cx = 52;
        $cy = 52;
        $outerR = 43;
        $innerR = 26;
        $svgPaths = [];

        if ($pieTotal > 0) {
            if (count($pieCounts) === 1) {
                $c = $pieColors[0] ?? '#3b82f6';
                $svgPaths[] = "<circle cx='{$cx}' cy='{$cy}' r='{$outerR}' fill='{$c}' />"
                            . "<circle cx='{$cx}' cy='{$cy}' r='{$innerR}' fill='#ffffff' />";
            } else {
                $currentAngle = -M_PI / 2;
                foreach ($pieCounts as $i => $count) {
                    if ($count <= 0) continue;

                    $fraction = $count / $pieTotal;
                    $angleSpan = $fraction * 2 * M_PI;
                    $endAngle = $currentAngle + $angleSpan;
                    $color = $pieColors[$i % count($pieColors)] ?? '#3b82f6';

                    $x1 = round($cx + $outerR * cos($currentAngle), 2);
                    $y1 = round($cy + $outerR * sin($currentAngle), 2);
                    $x2 = round($cx + $outerR * cos($endAngle), 2);
                    $y2 = round($cy + $outerR * sin($endAngle), 2);
                    $x3 = round($cx + $innerR * cos($endAngle), 2);
                    $y3 = round($cy + $innerR * sin($endAngle), 2);
                    $x4 = round($cx + $innerR * cos($currentAngle), 2);
                    $y4 = round($cy + $innerR * sin($currentAngle), 2);

                    $largeArc = $angleSpan > M_PI ? 1 : 0;
                    $path = "M {$x1} {$y1} A {$outerR} {$outerR} 0 {$largeArc} 1 {$x2} {$y2} "
                          . "L {$x3} {$y3} A {$innerR} {$innerR} 0 {$largeArc} 0 {$x4} {$y4} Z";

                    $svgPaths[] = "<path d='{$path}' fill='{$color}' stroke='#ffffff' stroke-width='1.2' />";
                    $currentAngle = $endAngle;
                }
            }
        }
    @endphp

    @foreach ($pages as $page)
        @include('admin.reports.SummaryReport.header', [
            'pageNumber' => $page['number'],
            'totalPages' => $page['total'],
        ])

        @if ($page['number'] === 1)
            <div class="report-header">
                <div class="label">Student Summary Report</div>
                <h1>Workstation Access Summary</h1>
                <div class="description">
                    Summarized student access activity and analytical overview for {{ $periodLabel }}.
                </div>
            </div>

            <table class="summary">
                <tr>
                    <td>
                        <span class="summary-label">Students Recorded</span>
                        <span class="summary-value">{{ number_format($students->count()) }}</span>
                    </td>
                    <td>
                        <span class="summary-label">Date Range</span>
                        <span class="summary-value">{{ $periodLabel }}</span>
                    </td>
                    <td>
                        <span class="summary-label">Generated</span>
                        <span class="summary-value">{{ $generatedAt->format('M d, Y h:i A') }}</span>
                    </td>
                </tr>
            </table>

            <div class="analytics-wrapper">
                <table class="analytics-table">
                    <tr>
                        <td class="analytics-col col-left">
                            <div class="section-title">Course Distribution (Overview)</div>

                            @if ($pieTotal > 0)
                                <table class="donut-layout">
                                    <tr>
                                        <td class="donut-cell">
                                            <svg viewBox="0 0 {{ $size }} {{ $size }}" width="{{ $size }}" height="{{ $size }}">
                                                {!! implode('', $svgPaths) !!}
                                                <text x="{{ $cx }}" y="{{ $cy - 2 }}" text-anchor="middle" font-size="11" font-weight="bold" fill="#0f172a">{{ number_format($pieTotal) }}</text>
                                                <text x="{{ $cx }}" y="{{ $cy + 7 }}" text-anchor="middle" font-size="5.5" fill="#64748b">Students</text>
                                            </svg>
                                        </td>
                                        <td class="legend-cell">
                                            <table class="legend-table">
                                                @foreach ($pieLabels as $idx => $label)
                                                    @php
                                                        $color = $pieColors[$idx % count($pieColors)] ?? '#3b82f6';
                                                        $count = $pieCounts[$idx] ?? 0;
                                                        $pct = $piePercentages[$idx] ?? 0;
                                                    @endphp
                                                    <tr class="legend-row">
                                                        <td class="legend-dot-col">
                                                            <span class="legend-dot" style="background-color: {{ $color }};"></span>
                                                        </td>
                                                        <td class="legend-course-col">{{ $label }}</td>
                                                        <td class="legend-count-col">
                                                            {{ number_format($count) }} <span class="muted">({{ $pct }}%)</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <div style="color: #94a3b8; font-size: 8px; padding: 22px; text-align: center;">
                                    No course distribution data available for this report.
                                </div>
                            @endif
                        </td>

                        <td class="analytics-col col-right">
                            <div class="section-title">Top Performers &amp; Activity Highlights</div>

                            <table class="lb-grid">
                                <tr>
                                    <td class="lb-box">
                                        <div class="lb-title">Top Students <span class="lb-subtitle">· Logins</span></div>
                                        <table class="lb-list">
                                            @forelse ($topStudentsByLogins ?? [] as $i => $s)
                                                <tr class="lb-item">
                                                    <td style="width: 14px;"><span class="rank-badge">#{{ $i + 1 }}</span></td>
                                                    <td class="name-cell">{{ $s->student_name ?: 'Unknown' }}</td>
                                                    <td class="val-pill">{{ number_format($s->login_count) }} log</td>
                                                </tr>
                                            @empty
                                                <tr class="lb-item"><td colspan="3" style="color: #94a3b8; text-align: center;">No records</td></tr>
                                            @endforelse
                                        </table>
                                    </td>

                                    <td class="lb-box">
                                        <div class="lb-title">Top Students <span class="lb-subtitle" style="color: #059669;">· Usage Time</span></div>
                                        <table class="lb-list">
                                            @forelse ($topStudentsByTime ?? [] as $i => $s)
                                                <tr class="lb-item">
                                                    <td style="width: 14px;"><span class="rank-badge">#{{ $i + 1 }}</span></td>
                                                    <td class="name-cell">{{ $s->student_name ?: 'Unknown' }}</td>
                                                    <td class="val-pill val-emerald">{{ $s->formatted_time }}</td>
                                                </tr>
                                            @empty
                                                <tr class="lb-item"><td colspan="3" style="color: #94a3b8; text-align: center;">No records</td></tr>
                                            @endforelse
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="lb-box">
                                        <div class="lb-title">Top Courses <span class="lb-subtitle">· Logins</span></div>
                                        <table class="lb-list">
                                            @forelse ($topCoursesByLogins ?? [] as $i => $c)
                                                <tr class="lb-item">
                                                    <td style="width: 14px;"><span class="rank-badge">#{{ $i + 1 }}</span></td>
                                                    <td class="name-cell">{{ $c->course }}</td>
                                                    <td class="val-pill">{{ number_format($c->login_count) }} log</td>
                                                </tr>
                                            @empty
                                                <tr class="lb-item"><td colspan="3" style="color: #94a3b8; text-align: center;">No records</td></tr>
                                            @endforelse
                                        </table>
                                    </td>

                                    <td class="lb-box">
                                        <div class="lb-title">Top Courses <span class="lb-subtitle" style="color: #7c3aed;">· Usage Time</span></div>
                                        <table class="lb-list">
                                            @forelse ($topCoursesByTime ?? [] as $i => $c)
                                                <tr class="lb-item">
                                                    <td style="width: 14px;"><span class="rank-badge">#{{ $i + 1 }}</span></td>
                                                    <td class="name-cell">{{ $c->course }}</td>
                                                    <td class="val-pill val-purple">{{ $c->formatted_time }}</td>
                                                </tr>
                                            @empty
                                                <tr class="lb-item"><td colspan="3" style="color: #94a3b8; text-align: center;">No records</td></tr>
                                            @endforelse
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th class="number">No.</th>
                    <th>Student</th>
                    <th>Student ID</th>
                    <th>Course</th>
                    <th>Allowed</th>
                    <th>Usage Time</th>
                    <th>First Access</th>
                    <th>Last Access</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($page['rows'] as $entry)
                    @php
                        $student = $entry['data'];
                        $usageSeconds = max(0, (int) ($student->usage_seconds ?? 0));
                        $usageHours = intdiv($usageSeconds, 3600);
                        $usageMinutes = intdiv($usageSeconds % 3600, 60);
                        $usageLabel = $usageHours > 0
                            ? $usageHours.'h '.$usageMinutes.'m'
                            : ($usageMinutes > 0 ? $usageMinutes.'m' : ($usageSeconds > 0 ? '<1m' : '0m'));
                    @endphp
                    <tr>
                        <td class="number">{{ $entry['number'] }}</td>
                        <td class="student">{{ $student->student_name ?: 'Unknown Student' }}</td>
                        <td>{{ $student->student_external_id }}</td>
                        <td>{{ $student->course ?: '—' }}</td>
                        <td>{{ number_format($student->allowed_accesses) }}</td>
                        <td>{{ $usageLabel }}</td>
                        <td class="muted">
                            {{ $student->first_access ? \Carbon\Carbon::parse($student->first_access)->format('M d, Y h:i A') : '—' }}
                        </td>
                        <td class="muted">
                            {{ $student->last_access ? \Carbon\Carbon::parse($student->last_access)->format('M d, Y h:i A') : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="empty" colspan="8">No student access records were found for the selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($page['number'] === 1)
            <div class="note">
                This document was generated automatically by the Workstation Access Control System.
            </div>
        @endif

        @include('admin.reports.SummaryReport.footer', [
            'pageNumber' => $page['number'],
            'totalPages' => $page['total'],
        ])

        @if (! $loop->last)
            @pageBreak
        @endif
    @endforeach
</body>
</html>
