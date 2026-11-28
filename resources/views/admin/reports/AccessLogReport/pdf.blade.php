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
            margin-bottom: 12px;
            padding-bottom: 8px;
        }

        .report-label {
            color: #2563eb;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .report-title {
            color: #0f172a;
            font-size: 17px;
            font-weight: bold;
            line-height: 1.25;
            margin: 3px 0;
        }

        .report-description {
            color: #64748b;
            font-size: 8.5px;
            line-height: 1.4;
            margin-top: 4px;
        }

        .report-summary {
            border-collapse: separate;
            border-spacing: 5px 0;
            margin-bottom: 12px;
            table-layout: fixed;
            width: 100%;
        }

        .report-summary td {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 7px 9px;
            text-align: center;
            width: 33.33%;
        }

        .summary-label {
            color: #94a3b8;
            display: block;
            font-size: 7px;
            font-weight: bold;
            letter-spacing: .6px;
            margin-bottom: 3px;
            text-transform: uppercase;
        }

        .summary-value {
            color: #334155;
            display: block;
            font-size: 10px;
            font-weight: bold;
        }

        table.data-table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }

        table.data-table thead {
            display: table-header-group;
        }

        table.data-table tr {
            page-break-inside: avoid;
        }

        table.data-table th {
            background: #1e3a8a;
            border: 1px solid #1e3a8a;
            color: #ffffff;
            font-size: 7.5px;
            font-weight: bold;
            letter-spacing: .4px;
            padding: 6px 5px;
            text-align: left;
            text-transform: uppercase;
        }

        table.data-table td {
            border: 1px solid #e2e8f0;
            color: #334155;
            font-size: 8px;
            line-height: 1.35;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        table.data-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .row-number {
            color: #64748b;
            font-weight: bold;
            text-align: center;
            width: 34px;
        }

        .student-name {
            color: #0f172a;
            font-weight: bold;
        }

        .course-text,
        .event-text {
            color: #334155;
            font-size: 8px;
            font-weight: bold;
        }

        .workstation {
            color: #334155;
            font-weight: bold;
        }

        .date-time {
            color: #475569;
            font-size: 8px;
            white-space: nowrap;
        }

        .muted {
            color: #94a3b8;
        }

        .empty-row td {
            color: #94a3b8;
            font-size: 9px;
            padding: 22px 8px !important;
            text-align: center !important;
        }

        .report-note {
            border-top: 1px solid #e2e8f0;
            color: #94a3b8;
            font-size: 7.5px;
            line-height: 1.5;
            margin-top: 10px;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    @php
        $columnCount = 1
            + ($columns['student_name'] ? 1 : 0)
            + ($columns['course'] ? 1 : 0)
            + ($columns['device'] ? 1 : 0)
            + ($columns['date_time'] ? 1 : 0)
            + ($columns['event'] ? 1 : 0);
    @endphp

    @foreach ($pages as $page)
        @include('admin.reports.AccessLogReport.header', [
            'pageNumber' => $page['number'],
            'totalPages' => $page['total'],
        ])

        @if ($page['number'] === 1)
            <div class="report-header">
                <div class="report-label">OLH Library Management</div>
                <h1 class="report-title">Device Access Control Report</h1>
                <div class="report-description">
                    Generated access activity report containing student, workstation and event records based on the selected report configuration.
                </div>
            </div>

            <table class="report-summary">
                <tr>
                    <td>
                        <span class="summary-label">Total Records</span>
                        <span class="summary-value">{{ number_format($logs->count()) }}</span>
                    </td>
                    <td>
                        <span class="summary-label">Generated Date</span>
                        <span class="summary-value">{{ $generatedAt->format('M d, Y') }}</span>
                    </td>
                    <td>
                        <span class="summary-label">Generated Time</span>
                        <span class="summary-value">{{ $generatedAt->format('h:i A') }}</span>
                    </td>
                </tr>
            </table>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: {{ $columnCount > 4 ? '5%' : '7%' }};">No.</th>

                    @if ($columns['student_name'])
                        <th>Student Name</th>
                    @endif

                    @if ($columns['course'])
                        <th>Course</th>
                    @endif

                    @if ($columns['device'])
                        <th>Workstation</th>
                    @endif

                    @if ($columns['date_time'])
                        <th>Date &amp; Time</th>
                    @endif

                    @if ($columns['event'])
                        <th>Event</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($page['rows'] as $entry)
                    @php($log = $entry['data'])
                    <tr>
                        <td class="row-number">{{ $entry['number'] }}</td>

                        @if ($columns['student_name'])
                            <td><span class="student-name">{{ $log->student_name ?: 'Unknown Student' }}</span></td>
                        @endif

                        @if ($columns['course'])
                            <td>
                                @if (! empty($log->course))
                                    <span class="course-text">{{ $log->course }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                        @endif

                        @if ($columns['device'])
                            <td><span class="workstation">{{ $log->workstation_name ?: 'N/A' }}</span></td>
                        @endif

                        @if ($columns['date_time'])
                            <td>
                                <span class="date-time">
                                    {{ $log->occurred_at ? \Carbon\Carbon::parse($log->occurred_at)->format('M d, Y h:i A') : '—' }}
                                </span>
                            </td>
                        @endif

                        @if ($columns['event'])
                            <td>
                                @if (! empty($log->event_type))
                                    <span class="event-text">{{ ucwords(str_replace('_', ' ', $log->event_type)) }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="{{ $columnCount }}">
                            No access records were found for the selected filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($page['number'] === 1)
            <div class="report-note">
                This document was generated automatically by the OLH Library Management System. Access records shown reflect the filters and columns selected at the time of generation.
            </div>
        @endif

        @include('admin.reports.AccessLogReport.footer', [
            'pageNumber' => $page['number'],
            'totalPages' => $page['total'],
        ])

        @if (! $loop->last)
            @pageBreak
        @endif
    @endforeach
</body>
</html>
