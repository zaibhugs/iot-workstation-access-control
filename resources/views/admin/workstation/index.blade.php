@extends('layout.app')

@section('title','Workstation')

@section('content')

@php
    /**
     * One consistent height for Search + Selects + Button
     */
    $controlHeight = 'h-[52px]';
@endphp

<div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3 lg:items-center">
    {{-- Search (2/3 width on lg) --}}
    <form class="w-full lg:col-span-2" method="GET" action="">
        <label for="search" class="sr-only">Search</label>

        <div class="relative">
            <input
                type="search"
                id="search"
                name="search"
                value="{{ request('search') }}"
                class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white pl-12 pr-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                placeholder="Search by workstation code..."
            />
        </div>
    </form>

    {{-- Right side: dropdown + button (each 1/3 width on lg) --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-1">
        <div class="w-full">
            <label for="status" class="sr-only">Status</label>
            <select
                id="status"
                name="status"
                class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option selected>All Status</option>
                <option>Active</option>
                <option>Inactive</option>
            </select>
        </div>

        <a
            href="{{ route('workstation.create') }}"
            class="inline-flex w-full {{ $controlHeight }} items-center justify-center gap-3 rounded-xl bg-blue-700 px-7 text-base font-medium text-white shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
            </svg>
            <span>Create WorkStation</span>
        </a>
    </div>
</div>

{{-- Table --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="relative overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700">
            <thead class="bg-white text-base font-semibold text-gray-700">
                <tr class="border-b border-gray-200">
                    <th scope="col" class="px-8 py-6">Workstation Code</th>
                    <th scope="col" class="px-8 py-6">Status</th>
                    <th scope="col" class="px-8 py-6">Device Code</th>
                    <th scope="col" class="px-8 py-6">Device Status</th>
                    <th scope="col" class="px-8 py-6">Slots</th>
                    <th scope="col" class="px-8 py-6 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                {{-- ROW 1 --}}
                <tr class="bg-white">
                    <td class="px-8 py-7 font-medium text-gray-900">WS-001</td>
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-700">
                            Active
                        </span>
                    </td>
                    <td class="px-8 py-7 text-gray-900">12345</td>
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-700">
                            <span class="h-2 w-2 rounded-full bg-green-600"></span>
                            Online
                        </span>
                    </td>
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-1 text-sm font-medium text-yellow-700">
                            Used 1/2
                        </span>
                    </td>
                    <td class="px-8 py-7">
                        <div class="flex items-center justify-center">
                            <button id="actionsButton1" data-dropdown-toggle="actionsDropdown1" data-dropdown-placement="bottom-end" type="button"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200">
                                <span class="sr-only">Open actions</span>
                                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 8a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 8a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"/>
                                </svg>
                            </button>

                            <div id="actionsDropdown1" class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg border border-gray-200 bg-white shadow">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="actionsButton1">
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">View</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a></li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- ROW 2 --}}
                <tr class="bg-gray-50/40">
                    <td class="px-8 py-7 font-medium text-gray-900">WS-002</td>
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-700">
                            Active
                        </span>
                    </td>
                    <td class="px-8 py-7 text-gray-900">67890</td>
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-700">
                            <span class="h-2 w-2 rounded-full bg-red-600"></span>
                            Offline
                        </span>
                    </td>
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-700">
                            Used 1/1
                        </span>
                    </td>
                    <td class="px-8 py-7">
                        <div class="flex items-center justify-center">
                            <button id="actionsButton2" data-dropdown-toggle="actionsDropdown2" data-dropdown-placement="bottom-end" type="button"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200">
                                <span class="sr-only">Open actions</span>
                                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 8a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 8a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"/>
                                </svg>
                            </button>

                            <div id="actionsDropdown2" class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg border border-gray-200 bg-white shadow">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="actionsButton2">
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">View</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a></li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- ROW 3 --}}
                <tr class="bg-white">
                    <td class="px-8 py-7 font-medium text-gray-900">WS-003</td>
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-700">
                            Active
                        </span>
                    </td>
                    <td class="px-8 py-7 text-gray-900">54321</td>
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-700">
                            <span class="h-2 w-2 rounded-full bg-green-600"></span>
                            Online
                        </span>
                    </td>
                    <td class="px-8 py-7">
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-4 py-1 text-sm font-medium text-blue-700">
                            Used 1/3
                        </span>
                    </td>
                    <td class="px-8 py-7">
                        <div class="flex items-center justify-center">
                            <button id="actionsButton3" data-dropdown-toggle="actionsDropdown3" data-dropdown-placement="bottom-end" type="button"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200">
                                <span class="sr-only">Open actions</span>
                                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 8a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm0 8a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"/>
                                </svg>
                            </button>

                            <div id="actionsDropdown3" class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg border border-gray-200 bg-white shadow">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="actionsButton3">
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">View</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a></li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection