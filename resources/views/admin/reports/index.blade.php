@extends('layout.app')

@section('title','Reports')

@section('content')

@php
    $controlHeight = 'h-[52px]';
@endphp

{{-- HEADER SECTION --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-heading">Access Reports</h1>
        <p class="mt-1 text-sm text-body">Showing {{ $logs->count() }} of the latest access events</p>
    </div>
</div>

{{-- FILTERS CARD --}}
<form method="GET" action="{{ route('reports') }}">
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-12">
            <div class="xl:col-span-1">
                <label for="date-from" class="text-xs font-medium text-gray-500">Date from</label>
                <input
                    type="date"
                    name="date_from"
                    id="date-from"
                    value="{{ request('date_from') }}"
                    class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                />
            </div>

            <div class="xl:col-span-1">
                <label for="date-to" class="text-xs font-medium text-gray-500">Date to</label>
                <input
                    type="date"
                    name="date_to"
                    id="date-to"
                    value="{{ request('date_to') }}"
                    class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                />
            </div>

            <div class="xl:col-span-1">
                <label for="course" class="text-xs font-medium text-gray-500">Course</label>
                <select
                    name="course"
                    id="course"
                    class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                >
                    <option value="">All Courses</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course }}" @selected(request('course') === $course)>{{ $course }}</option>
                    @endforeach
                </select>
            </div>

            <div class="xl:col-span-1">
                <label for="workstation" class="text-xs font-medium text-gray-500">Workstation</label>
                <select
                    name="workstation"
                    id="workstation"
                    class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                    <option value="">All Workstations</option>
                    @foreach ($workstations as $ws)
                        <option value="{{ $ws->id }}" @selected((string) request('workstation') === (string) $ws->id)>{{ $ws->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="xl:col-span-1">
                <label for="event" class="text-xs font-medium text-gray-500">Event</label>
                <select
                    name="event"
                    id="event"
                    class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                    <option value="">All Events</option>
                    @foreach ($events as $event)
                        <option value="{{ $event }}" @selected(request('event') === $event)>{{ ucwords(str_replace('_', ' ', $event)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="xl:col-span-1">
                <label for="result" class="text-xs font-medium text-gray-500">Result</label>
                <select
                    name="result"
                    id="result"
                    class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                >
                    <option value="">All Results</option>
                    <option value="allowed" @selected(request('result') === 'allowed')>Success</option>
                    <option value="denied" @selected(request('result') === 'denied')>Fail</option>
                </select>
            </div>

            <div class="xl:col-span-1">
                <label for="reason" class="text-xs font-medium text-gray-500">Reason</label>
                <select
                    name="reason"
                    id="reason"
                    class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                    <option value="">All Reasons</option>
                    @foreach ($reasons as $reason)
                        <option value="{{ $reason }}" @selected(request('reason') === $reason)>{{ ucwords($reason) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Action Buttons Wrapper --}}
        <div class="mt-4 grid grid-cols-2 gap-2">
            <button type="submit" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl bg-blue-700 px-5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-800">
                Apply
            </button>
            <a href="{{ route('reports') }}" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl border border-gray-200 bg-white px-5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                Reset
            </a>
        </div>
    </div>
</form>

{{-- DATA TABLE CONTAINER --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="relative overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700 whitespace-nowrap">
            <thead class="bg-white text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr class="border-b border-gray-200">
                    <th class="px-6 py-4">Date & Time</th>
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Course</th>
                    <th class="px-6 py-4">Workstation</th>
                    <th class="px-6 py-4">Event</th>
                    <th class="px-6 py-4">Result</th>
                    <th class="px-6 py-4">Reason</th>
                    <th class="px-6 py-4">Session ID</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($logs as $log)
                    @php
                        $eventBadge = match ($log->event_type) {
                            'time_in'  => 'bg-green-100 text-green-800',
                            'time_out' => 'bg-red-100 text-red-800',
                            'denied'   => 'bg-amber-100 text-amber-800',
                            default    => 'bg-gray-100 text-gray-600',
                        };
                        $resultBadge = $log->result === 'allowed'
                            ? 'bg-green-100 text-green-800'
                            : 'bg-red-100 text-red-800';
                        $eventLabel = ucwords(str_replace('_', ' ', $log->event_type));
                        $resultLabel = ucwords($log->result);
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $log->occurred_at?->format('Y-m-d H:i:s') }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $log->student_name ?: '—' }}</div>
                            @if ($log->student_external_id)
                                <div class="text-xs text-gray-400">{{ $log->student_external_id }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $log->course ?: '—' }}</td>
                        <td class="px-6 py-4">{{ $log->workstation?->name ?: '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $eventBadge }}">
                                {{ $eventLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $resultBadge }}">
                                {{ $resultLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $log->reason ?: '—' }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500">{{ $log->session_id ?: '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-500">
                            No access events match the current filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection