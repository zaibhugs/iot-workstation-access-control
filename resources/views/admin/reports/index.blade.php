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
	<div class="grid grid-cols-2 gap-4 xl:grid-cols-12">
		<div>
			<label for="date-from" class="text-xs font-medium text-gray-500">Date from</label>
			<input
				type="date"
				id="date-from"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			/>
		</div>

		<div>
			<label for="date-to" class="text-xs font-medium text-gray-500">Date to</label>
			<input
				type="date"
				id="date-to"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			/>
		</div>

		<div>
			<label for="workstation" class="text-xs font-medium text-gray-500">Workstation</label>
			<select
				id="workstation"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			>
				<option>All workstations</option>
				<!-- data option will get from the database-->
			</select>
		</div>

		<div>
			<label for="result" class="text-xs font-medium text-gray-500">Result</label>
			<select
				id="result"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			>
				<option>All results</option>
				<option>Success</option>
				<option>Fail</option>
			</select>
		</div>

		<div class="xl:col-span-2">
			<label for="course" class="text-xs font-medium text-gray-500">Course</label>
			<select
				id="course"
				class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
			>
				<option>All courses</option>
				<!-- data option will get from the database-->
			</select>
		</div>
        <button type="button" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl bg-blue-700 px-5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-800">
            Apply
        </button>
        <button type="button" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl border border-gray-200 bg-white px-5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
            Reset
        </button>
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
                <tr class="border-b border-gray-200">
                    <td class="px-6 py-4">2026-04-13 08:15:23</td>
                    <td class="px-6 py-4">Hannah Dalmacio</td>
                    <td class="px-6 py-4">BSIT</td>
                    <td class="px-6 py-4">DVC001</td>
                    <td class="px-6 py-4">Login</td>
                    <td class="px-6 py-4 text-green-700">Success</td>
                    <td class="px-6 py-4">Authorized</td>
                    <td class="px-6 py-4">ABC123XYZ</td>
                </tr>
				<!-- data rows will be populated from the database -->
			</tbody>
		</table>
	</div>
</div>

@endsection
