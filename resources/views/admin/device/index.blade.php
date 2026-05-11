@extends('layout.app')

@section('title','Devices')

@section('content')

@php
    $controlHeight = 'h-[52px]';
@endphp

{{-- Toolbar --}}
<div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    {{-- Left: Search --}}
    <form class="w-full lg:max-w-[520px]" method="GET" action="{{ route('device') }}">
        <label for="search" class="sr-only">Search</label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
            </div>
            <input
                type="search"
                id="search"
                name="search"
                value="{{ request('search') }}"
                class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white pl-12 pr-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                placeholder="Search by device code or name..."
            />
        </div>
    </form>

    {{-- Right: Status + Add Device --}}
    <div class="flex w-full flex-col gap-4 sm:flex-row lg:w-auto lg:items-center lg:justify-end">
        <form action="{{ route('device') }}" method="GET" class="w-full sm:w-56">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <label for="status" class="sr-only">Status</label>
            <select
                id="status"
                name="status"
                onchange="this.form.submit()"
                class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option value="">All Status</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
            </select>
        </form>

        <a
            href="{{ route('device.create') }}"
            class="inline-flex w-full sm:w-auto {{ $controlHeight }} items-center justify-center gap-3 rounded-xl bg-blue-700 px-7 text-base font-medium text-white shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
            </svg>
            <span>Add Device</span>
        </a>
    </div>
</div>

{{-- Table wrapper --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="relative overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700">
            <thead class="bg-white text-base font-semibold text-gray-700">
                <tr class="border-b border-gray-200">
                    <th scope="col" class="px-8 py-6">Device Code</th>
                    <th scope="col" class="px-8 py-6">Status</th>
                    <th scope="col" class="px-8 py-6">Connection</th>
                    <th scope="col" class="px-8 py-6">Port Capacity (Max 2)</th>
                    <th scope="col" class="px-8 py-6">Last Seen</th>
                    <th scope="col" class="px-8 py-6 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($devices as $device)
                <tr class="{{ $loop->even ? 'bg-gray-50/40' : 'bg-white' }} transition-colors hover:bg-blue-50/30">
                    <td class="px-8 py-7 font-medium text-blue-700">{{ $device->device_uid }}</td>
                    
                    {{-- Status Badge --}}
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full px-4 py-1 text-sm font-medium {{ $device->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $device->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    {{-- Connection Badge --}}
                    <td class="px-8 py-7">
                        @php
                            $isOnline = $device->last_seen_at && $device->last_seen_at->gt(now()->subMinutes(5));
                        @endphp
                        <span class="inline-flex items-center gap-2 rounded-full px-4 py-1 text-sm font-medium {{ $isOnline ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            <span class="h-2 w-2 rounded-full {{ $isOnline ? 'bg-green-600' : 'bg-red-600' }}"></span>
                            {{ $isOnline ? 'Online' : 'Offline' }}
                        </span>
                    </td>

                    {{-- Port/Remaining Logic --}}
                    <td class="px-8 py-7">
                        @php
                            $maxPorts = 2;
                            $usedPorts = $device->device_workstations_count ?? 0;
                            $remaining = $maxPorts - $usedPorts;
                        @endphp

                        @if($usedPorts >= $maxPorts)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-4 py-1 text-sm font-bold text-red-700">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                Full
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-blue-50 border border-blue-200 px-4 py-1 text-sm font-medium text-blue-700">
                                {{ $remaining }} {{ Str::plural('slot', $remaining) }} available
                            </span>
                        @endif
                    </td>

                    <td class="px-8 py-7 text-gray-600">
                        {{ $device->last_seen_at ? $device->last_seen_at->diffForHumans() : 'Never' }}
                    </td>

                    <td class="px-8 py-7">
                        <div class="flex items-center justify-center gap-4">

                            <a href="#" class="text-gray-400 hover:text-amber-600 transition-colors" title="Edit Device">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <svg class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-lg font-medium">No devices found</p>
                            <p class="text-sm">Try adjusting your search or filters.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination Links --}}
<div class="mt-6">
    {{ $devices->links() }}
</div>

@endsection