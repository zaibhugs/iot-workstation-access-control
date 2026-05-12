@extends('layout.app')

@section('title', 'Devices')

@section('content')

@php
    /**
     * Consistent height for Search + Selects + Button
     */
    $controlHeight = 'h-[52px]';
@endphp

{{-- Toolbar --}}
<div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3 lg:items-center">
    {{-- Left: Search (2/3 width on lg) --}}
    <form class="w-full lg:col-span-2" method="GET" action="{{ route('device') }}">
        <label for="search" class="sr-only">Search</label>
        <div class="relative flex items-center">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"></div>
            <input
                type="search"
                id="search"
                name="search"
                value="{{ request('search') }}"
                class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white pl-12 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                placeholder="Search by device code or name..."
            />
            @if(request('search'))
                <a href="{{ route('device') }}" class="absolute right-3 flex items-center text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </a>
            @endif
        </div>
    </form>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-1">
        <form action="{{ route('device') }}" method="GET" class="w-full">
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
            class="inline-flex w-full {{ $controlHeight }} items-center justify-center gap-3 rounded-xl bg-blue-700 px-7 text-base font-medium text-white shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
            </svg>
            <span>Add Device</span>
        </a>
    </div>
</div>

@if($devices->total() > $devices->perPage())
    
@endif

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="relative overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700">
            <thead class="bg-white text-base font-semibold text-black border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-8 py-6">Device Code</th>
                    <th scope="col" class="px-8 py-6 text-center">Status</th>
                    <th scope="col" class="px-8 py-6 text-center">Connection</th>
                    <th scope="col" class="px-8 py-6 text-center">Port Capacity</th>
                    <th scope="col" class="px-8 py-6">Last Seen</th>
                    <th scope="col" class="px-8 py-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($devices as $device)
                <tr class="{{ $loop->even ? 'bg-gray-50/40' : 'bg-white' }} transition-colors hover:bg-blue-50/30">
                    <td class="px-8 py-7 font-medium text-gray-900">{{ $device->device_uid }}</td>
                    <td class="px-8 py-7 text-center">
                        <span class="inline-flex items-center rounded-full px-4 py-1 text-sm font-medium {{ $device->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $device->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-8 py-7 text-center">
                        @php
                            $isOnline = $device->last_seen_at && $device->last_seen_at->gt(now()->subMinutes(5));
                        @endphp
                        <span class="inline-flex items-center gap-2 rounded-full px-4 py-1 text-sm font-medium {{ $isOnline ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            <span class="h-2 w-2 rounded-full {{ $isOnline ? 'bg-green-600 animate-pulse' : 'bg-red-600' }}"></span>
                            {{ $isOnline ? 'Online' : 'Offline' }}
                        </span>
                    </td>
                    <td class="px-8 py-7 text-center">
                        @php
                            $maxPorts = 2;
                            $usedPorts = $device->device_workstations_count ?? 0;
                            $percentage = ($usedPorts / $maxPorts) * 100;
                            $colorClass = $usedPorts >= $maxPorts ? 'text-red-700' : ($usedPorts > 0 ? 'text-yellow-700' : 'text-blue-700');
                            $bgClass = $usedPorts >= $maxPorts ? 'bg-red-100' : ($usedPorts > 0 ? 'bg-yellow-100' : 'bg-blue-100');
                            $barColor = $usedPorts >= $maxPorts ? 'bg-red-500' : ($usedPorts > 0 ? 'bg-yellow-500' : 'bg-blue-500');
                        @endphp

                        <div class="flex flex-col items-center gap-2">
                            <span class="inline-flex items-center rounded-full {{ $bgClass }} px-4 py-1 text-sm font-medium {{ $colorClass }}">
                                {{ $usedPorts }}/{{ $maxPorts }} Slots
                            </span>
                            <div class="h-1.5 w-24 overflow-hidden rounded-full bg-gray-100">
                                <div class="h-full {{ $barColor }} transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-7 text-gray-900">
                        {{ $device->last_seen_at ? $device->last_seen_at->diffForHumans() : 'Never' }}
                    </td>
                    <td class="px-8 py-7">
                        <div class="flex items-center justify-center gap-3">
                            <a href="" class="group rounded-lg p-2 hover:bg-amber-50 transition-all" title="Edit">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="" method="POST" class="inline-block" onsubmit="return confirm('Delete this device?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="group rounded-lg p-2 hover:bg-red-50 transition-all" title="Delete">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-24 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xl font-semibold text-gray-900">No devices found</p>
                            <p class="text-gray-500">Try adjusting your search or filters.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Flowbite pagination --}}
<div class="mt-6">
    {{ $devices->onEachSide(1)->links('vendor.pagination.flowbite') }}
</div>

@endsection