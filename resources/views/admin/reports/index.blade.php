@extends('layout.app')

@section('title','Reports')

@section('content')

@php
	$controlHeight = 'h-[52px]';
@endphp

<div class="mb-6 flex items-center justify-between">
	<div>
		<h1 class="text-2xl font-semibold text-gray-900">Access log report</h1>
		<p class="text-sm text-gray-500">Full history of workstation access events</p>
	</div>
	<div class="flex flex-wrap gap-2">
		<button type="button" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
			Export CSV
		</button>
		<button type="button" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
			Export PDF
		</button>
	</div>
</div>

<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
	<div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
		<div class="xl:col-span-2">
			<label for="date-from" class="text-xs font-medium text-gray-500">Date from</label>
			<input
				type="date"
				id="date-from"
				value="2026-04-13"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			/>
		</div>

		<div class="xl:col-span-2">
			<label for="date-to" class="text-xs font-medium text-gray-500">Date to</label>
			<input
				type="date"
				id="date-to"
				value="2026-05-12"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			/>
		</div>

		<div class="xl:col-span-2">
			<label for="workstation" class="text-xs font-medium text-gray-500">Workstation</label>
			<select
				id="workstation"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			>
				<option>All workstations</option>
				<option>PC-01</option>
				<option>PC-02</option>
				<option>PC-03</option>
				<option>PC-04</option>
			</select>
		</div>

		<div class="xl:col-span-2">
			<label for="event-type" class="text-xs font-medium text-gray-500">Event type</label>
			<select
				id="event-type"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			>
				<option>All events</option>
				<option>Login</option>
				<option>Logout</option>
			</select>
		</div>

		<div class="xl:col-span-2">
			<label for="result" class="text-xs font-medium text-gray-500">Result</label>
			<select
				id="result"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			>
				<option>All results</option>
				<option>Granted</option>
				<option>Denied</option>
			</select>
		</div>

		<div class="xl:col-span-2">
			<label for="course" class="text-xs font-medium text-gray-500">Course</label>
			<select
				id="course"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			>
				<option>All courses</option>
				<option>BSCS</option>
				<option>BSIT</option>
				<option>BSECE</option>
			</select>
		</div>

		<div class="xl:col-span-4">
			<label for="search" class="text-xs font-medium text-gray-500">Search</label>
			<div class="mt-1 flex gap-2">
				<input
					type="search"
					id="search"
					placeholder="Name or student ID"
					class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
				/>
				<button type="button" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl bg-blue-700 px-5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-800">
					Apply
				</button>
				<button type="button" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl border border-gray-200 bg-white px-5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
					Reset
				</button>
			</div>
		</div>
	</div>
</div>

<div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-12">
	<div class="lg:col-span-3">
		<div class="h-full rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
			<p class="text-xs font-medium uppercase tracking-wide text-gray-500">Total events</p>
			<p class="mt-2 text-3xl font-semibold text-gray-900">32</p>
		</div>
	</div>
	<div class="lg:col-span-3">
		<div class="h-full rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
			<p class="text-xs font-medium uppercase tracking-wide text-gray-500">Granted</p>
			<p class="mt-2 text-3xl font-semibold text-green-700">26</p>
		</div>
	</div>
	<div class="lg:col-span-3">
		<div class="h-full rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
			<p class="text-xs font-medium uppercase tracking-wide text-gray-500">Denied</p>
			<p class="mt-2 text-3xl font-semibold text-red-700">6</p>
		</div>
	</div>
	<div class="lg:col-span-3">
		<div class="h-full rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
			<p class="text-xs font-medium uppercase tracking-wide text-gray-500">Unique students</p>
			<p class="mt-2 text-3xl font-semibold text-gray-900">8</p>
		</div>
	</div>
</div>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
	<div class="relative overflow-x-auto">
		<table class="w-full text-left text-sm text-gray-700">
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
				<tr class="bg-white transition-colors hover:bg-blue-50/30">
					<td class="px-6 py-4">2026-05-03 13:24</td>
					<td class="px-6 py-4">
						<p class="font-medium text-gray-900">Juan dela Cruz</p>
						<p class="text-xs text-gray-500">2022-00123</p>
					</td>
					<td class="px-6 py-4">BSCS</td>
					<td class="px-6 py-4">PC-01</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">Login</span>
					</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">Granted</span>
					</td>
					<td class="px-6 py-4 text-gray-500">-</td>
					<td class="px-6 py-4 text-gray-500">sess-a1b2</td>
				</tr>

				<tr class="bg-gray-50/40 transition-colors hover:bg-blue-50/30">
					<td class="px-6 py-4">2026-05-03 15:29</td>
					<td class="px-6 py-4">
						<p class="font-medium text-gray-900">Juan dela Cruz</p>
						<p class="text-xs text-gray-500">2022-00123</p>
					</td>
					<td class="px-6 py-4">BSCS</td>
					<td class="px-6 py-4">PC-01</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">Logout</span>
					</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">Granted</span>
					</td>
					<td class="px-6 py-4 text-gray-500">-</td>
					<td class="px-6 py-4 text-gray-500">sess-a1b2</td>
				</tr>

				<tr class="bg-white transition-colors hover:bg-blue-50/30">
					<td class="px-6 py-4">2026-05-03 10:05</td>
					<td class="px-6 py-4">
						<p class="font-medium text-gray-900">Maria Santos</p>
						<p class="text-xs text-gray-500">2022-00456</p>
					</td>
					<td class="px-6 py-4">BSIT</td>
					<td class="px-6 py-4">PC-03</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">Login</span>
					</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">Denied</span>
					</td>
					<td class="px-6 py-4 text-gray-500">Unregistered RFID</td>
					<td class="px-6 py-4 text-gray-500">-</td>
				</tr>

				<tr class="bg-gray-50/40 transition-colors hover:bg-blue-50/30">
					<td class="px-6 py-4">2026-05-03 10:08</td>
					<td class="px-6 py-4">
						<p class="font-medium text-gray-900">Maria Santos</p>
						<p class="text-xs text-gray-500">2022-00456</p>
					</td>
					<td class="px-6 py-4">BSIT</td>
					<td class="px-6 py-4">PC-03</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">Login</span>
					</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">Granted</span>
					</td>
					<td class="px-6 py-4 text-gray-500">-</td>
					<td class="px-6 py-4 text-gray-500">sess-c3d4</td>
				</tr>

				<tr class="bg-white transition-colors hover:bg-blue-50/30">
					<td class="px-6 py-4">2026-05-02 09:15</td>
					<td class="px-6 py-4">
						<p class="font-medium text-gray-900">Carlo Reyes</p>
						<p class="text-xs text-gray-500">2021-00789</p>
					</td>
					<td class="px-6 py-4">BSECE</td>
					<td class="px-6 py-4">PC-02</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">Login</span>
					</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">Granted</span>
					</td>
					<td class="px-6 py-4 text-gray-500">-</td>
					<td class="px-6 py-4 text-gray-500">sess-e5f6</td>
				</tr>

				<tr class="bg-gray-50/40 transition-colors hover:bg-blue-50/30">
					<td class="px-6 py-4">2026-05-02 11:21</td>
					<td class="px-6 py-4">
						<p class="font-medium text-gray-900">Ana Mendoza</p>
						<p class="text-xs text-gray-500">2022-00102</p>
					</td>
					<td class="px-6 py-4">BSCS</td>
					<td class="px-6 py-4">PC-04</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">Login</span>
					</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">Denied</span>
					</td>
					<td class="px-6 py-4 text-gray-500">Unauthorized time slot</td>
					<td class="px-6 py-4 text-gray-500">-</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="flex items-center justify-between border-t border-gray-200 px-6 py-4 text-sm text-gray-500">
		<p>Showing 1-10 of 32</p>
		<div class="flex items-center gap-2">
			<button type="button" class="rounded-lg border border-gray-200 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Prev</button>
			<button type="button" class="rounded-lg border border-gray-200 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Next</button>
		</div>
	</div>
</div>

@endsection
