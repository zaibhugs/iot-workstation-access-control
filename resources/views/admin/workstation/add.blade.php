@extends('layout.app')

@section('title','Workstation')

@section('content')
    {{-- Top bar (Back button on the far right) --}}
    <div class="w-full flex justify-end mb-4">
        <a href="{{ route('workstation') }}"
        class="inline-flex items-center gap-2 rounded-base px-3 py-2 text-sm border border-gray-300 hover:border-gray-400">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
        </svg>
        Back
        </a>
    </div>


    <div class="w-full flex justify-center">
        <div class="w-full max-w-5xl flex flex-col md:flex-row gap-6 md:items-stretch md:justify-end">
        <div class="w-full md:max-w-md">
            <div
            class="w-full h-full min-h-105 bg-neutral-primary-medium border border-default-medium rounded-lg flex items-center justify-center">
            <svg class="w-40 h-40 text-body" aria-hidden="true"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 17h10M9 20h6M6 16h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z" />
            </svg>
            </div>
        </div>

        {{-- Right: Form --}}
        <div class="w-full md:max-w-md">
            <div class="bg-white rounded-lg shadow p-6 h-full">
            <h1 class="text-lg font-semibold mb-6">Create Workstation</h1>

            <form class="space-y-4">
                <div>
                <label for="workstation_code" class="block mb-2 text-sm font-medium text-heading">
                    Work Station Code
                </label>
                <input
                    type="text"
                    id="workstation_code"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                    placeholder="WS-001"
                    required
                />
                </div>

                {{-- Device Id (dropdown) --}}
    <div>
    <label for="device_id" class="block mb-2 text-sm font-medium text-heading">
        Device Id
    </label>

    <select
        id="device_id"
        name="device_id"
        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
        required
    >
        <option value="" selected disabled>Select a device...</option>
        <option value="12345">12345</option>
        <option value="67890">67890</option>
        <option value="ABCDE">ABCDE</option>
    </select>
    </div>

            {{-- Status (dropdown) --}}
            <div>
            <label for="status" class="block mb-2 text-sm font-medium text-heading">
                Status
            </label>

            <select
                id="status"
                name="status"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                required
            >
                <option value="Active" selected>Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            </div>

            <button
            type="submit"
            class="w-full text-black bg-brand hover:bg-brand-strong
            border border-gray-300 hover:border-gray-400
            focus:ring-4 focus:ring-brand-medium shadow-xs font-medium rounded-base text-sm px-4 py-2.5 focus:outline-none"
                >
                Submit
                </button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endsection
