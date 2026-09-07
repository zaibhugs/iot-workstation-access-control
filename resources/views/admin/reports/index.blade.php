@extends('layout.app')

@section('title', 'Reports')

@section('content')

<div class="min-h-[calc(100vh-5rem)] rounded-3xl bg-gradient-to-br from-slate-50 via-sky-50/50 to-blue-100/40 p-4 sm:p-6 lg:p-8">
    
    {{-- HEADER SECTION --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Reports Dashboard</h1>
            <p class="mt-1 text-sm text-slate-600">Review workstation access activity, monitor usage patterns, and filter audit trails.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('reports.csv', request()->query()) }}" title="Download detailed CSV report" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-100">
                <svg class="h-4 w-4 text-emerald-600" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2" />
                </svg>
                Export CSV
            </a>
            <a href="{{ route('reports.pdf', request()->query()) }}" title="Download formal PDF report" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:bg-rose-50 hover:border-rose-200 hover:text-rose-800 focus:outline-none focus:ring-4 focus:ring-rose-100">
                <svg class="h-4 w-4 text-rose-500" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v5h5M8 15h8M8 18h6" />
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    {{-- FILTERS CARD --}}
    <form method="GET" action="{{ route('reports') }}" class="mb-6 rounded-2xl border border-slate-200/80 bg-white/80 p-5 shadow-sm backdrop-blur-md sm:p-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            
            <div>
                <label for="date_from" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Date From</label>
                <input
                    type="date"
                    id="date_from"
                    name="date_from"
                    value="{{ request('date_from') }}"
                    class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                />
            </div>

            <div>
                <label for="date_to" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Date To</label>
                <input
                    type="date"
                    id="date_to"
                    name="date_to"
                    value="{{ request('date_to') }}"
                    class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                />
            </div>

            <div>
                <label for="course" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Course</label>
                <select
                    id="course"
                    name="course"
                    class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                >
                    <option value="">All Courses</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>{{ $course }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="workstation" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Workstation</label>
                <select
                    id="workstation"
                    name="workstation"
                    class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                >
                    <option value="">All Workstations</option>
                    @foreach ($workstations as $workstation)
                        <option value="{{ $workstation }}" {{ request('workstation') == $workstation ? 'selected' : '' }}>{{ $workstation }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="event" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Event</label>
                <select
                    id="event"
                    name="event"
                    class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                >
                    <option value="">All Events</option>
                    @foreach ($events as $event)
                        <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>{{ $event }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="result" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Result</label>
                <select
                    id="result"
                    name="result"
                    class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                >
                    <option value="">All Results</option>
                    @foreach ($results as $result)
                        <option value="{{ $result }}" {{ request('result') == $result ? 'selected' : '' }}>{{ $result }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="reason" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Reason</label>
                <select
                    id="reason"
                    name="reason"
                    class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                >
                    <option value="">All Reasons</option>
                    @foreach ($reasons as $reason)
                        <option value="{{ $reason }}" {{ request('reason') == $reason ? 'selected' : '' }}>{{ $reason }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Action Buttons Wrapper --}}
        <div class="mt-5 flex flex-col sm:flex-row items-center gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="inline-flex h-11 w-full sm:w-auto items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-6 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">
                <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Apply Filters
            </button>
            <a href="{{ route('reports') }}" class="inline-flex h-11 w-full sm:w-auto items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-6 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">
                <svg class="h-4 w-4 text-slate-500" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h5M20 20v-5h-5M5.5 9A7 7 0 0 1 17 6.5L20 9M18.5 15A7 7 0 0 1 7 17.5L4 15" />
                </svg>
                Reset Filters
            </a>
        </div>
    </form>

    {{-- DATA TABLE CONTAINER --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <div class="relative overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4">Name</th>
                        <th scope="col" class="px-6 py-4">Course</th>
                        <th scope="col" class="px-6 py-4">Workstation</th>
                        <th scope="col" class="px-6 py-4">Date and Time</th>
                        <th scope="col" class="px-6 py-4">Event</th>

                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($logs as $log)
                        <tr class="transition-colors hover:bg-sky-50/50">
                            <td class="px-6 py-4 font-mono font-semibold text-slate-900">{{ $log->student_name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $log->course }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $log->workstation}}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                    {{ $log->occurred_at}}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $log->event_type }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm font-medium text-slate-600">No access logs found matching your filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $logs->onEachSide(1)->links('vendor.pagination.flowbite') }}
    </div>
</div>
@endsection