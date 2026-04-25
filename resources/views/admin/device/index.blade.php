@extends('layout.app')

@section('title','Devices')

@section('content')

@php

    $controlHeight = 'h-[52px]';
@endphp

{{-- Toolbar --}}
<div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    {{-- Left: Search --}}
    <form class="w-full lg:max-w-[520px]" method="GET" action="">
        <label for="search" class="sr-only">Search</label>

        <div class="relative">
            <input
                type="search"
                id="search"
                name="search"
                value="{{ request('search') }}"
                class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white pl-12 pr-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                placeholder="Search by device code..."
            />
        </div>
    </form>

    {{-- Right: Status + Add Device --}}
    <div class="flex w-full flex-col gap-4 sm:flex-row lg:w-auto lg:items-center lg:justify-end">
        <div class="w-full sm:w-56">
            <label for="status" class="sr-only">Status</label>
            <select
                id="status"
                name="status"
                class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option value="" selected>All Status</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
            </select>
        </div>

        <a
            href="{{route('device.create')}}"
            class="inline-flex w-full sm:w-auto {{ $controlHeight }} items-center justify-center gap-3 rounded-xl bg-blue-700 px-7 text-base font-medium text-white shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
            </svg>
            <span>Add Device</span>
        </a>
    </div>
</div>

{{-- Table wrapper (rounded card like screenshot) --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="relative overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700">
            <thead class="bg-white text-base font-semibold text-gray-700">
                <tr class="border-b border-gray-200">
                    <th scope="col" class="px-8 py-6">Device Code</th>
                    <th scope="col" class="px-8 py-6">Name</th>
                    <th scope="col" class="px-8 py-6">Status</th>
                    <th scope="col" class="px-8 py-6">Connection</th>
                    {{-- <th scope="col" class="px-8 py-6">Slots</th> --}}
                    <th scope="col" class="px-8 py-6">Remaining</th>
                    <th scope="col" class="px-8 py-6">Last Seen</th>
                    <th scope="col" class="px-8 py-6 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                {{-- Example rows (replace with @foreach later) --}}
                <tr class="bg-white">
                    <td class="px-8 py-7 font-medium text-blue-700">12345</td>
                    <td class="px-8 py-7 text-gray-900">Main Door</td>

                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-700">
                            Active
                        </span>
                    </td>

                    <td class="px-8 py-7">
                        <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-700">
                            <span class="h-2 w-2 rounded-full bg-red-600"></span>
                            Offline
                        </span>
                    </td>

                    {{-- <td class="px-8 py-7">
                        {{-- <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-1 text-sm font-medium text-yellow-700">
                            Used 1/2
                        </span> 
                    </td> --}}

                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-1 text-sm font-medium text-yellow-700">
                            1 remaining
                        </span>
                    </td>

                    <td class="px-8 py-7 text-gray-700">about 14 hours ago</td>

                    <td class="px-8 py-7">
                        <div class="flex items-center justify-center gap-4">
                            {{-- View --}}
                            <a href="#" class="text-gray-600 hover:text-gray-900" title="View">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5Z"/>
                                </svg>
                            </a>

                            {{-- Edit --}}
                            <a href="#" class="text-gray-600 hover:text-gray-900" title="Edit">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487 19.5 7.125m-2.638-2.638L7.5 13.85V16.5h2.65l9.362-9.375ZM6 18h12"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>

                <tr class="bg-gray-50/40">
                    <td class="px-8 py-7 font-medium text-blue-700">67890</td>
                    <td class="px-8 py-7 text-gray-900">Server Room</td>

                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-700">
                            Active
                        </span>
                    </td>

                    <td class="px-8 py-7">
                        <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-700">
                            <span class="h-2 w-2 rounded-full bg-red-600"></span>
                            Offline
                        </span>
                    </td>

                    {{-- <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-700">
                            Used 1/1
                        </span>
                    </td> --}}

                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-700">
                            Full
                        </span>
                    </td>

                    <td class="px-8 py-7 text-gray-700">about 14 hours ago</td>

                    <td class="px-8 py-7">
                        <div class="flex items-center justify-center gap-4">
                            <a href="#" class="text-gray-600 hover:text-gray-900" title="View">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5Z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-gray-900" title="Edit">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487 19.5 7.125m-2.638-2.638L7.5 13.85V16.5h2.65l9.362-9.375ZM6 18h12"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection