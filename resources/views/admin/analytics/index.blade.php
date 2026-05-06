@extends('layout.app')

@section('title','Analytics')

@section('content')


    <ul class="hidden text-sm font-medium text-center text-body sm:flex -space-x-px" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
        <li class="w-full focus-within:z-10" role="presentation">
            <button id="all-tab" data-tabs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true" class="inline-flex items-center justify-center w-full text-body bg-neutral-primary-soft border border-default rounded-s-base hover:bg-neutral-secondary-medium hover:text-heading focus:ring-2 focus:ring-neutral-secondary-strong font-medium leading-5 text-sm px-4 py-2.5 focus:outline-none">
                <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z"/></svg>
                All
            </button>
        </li>
        <li class="w-full focus-within:z-10" role="presentation">
            <button id="students-tab" data-tabs-target="#students" type="button" role="tab" aria-controls="students" aria-selected="false" class="inline-flex items-center justify-center  w-full text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-2 focus:ring-neutral-secondary-strong font-medium leading-5 text-sm px-4 py-2.5 focus:outline-none">
                <svg class="w-[19px] h-[19px] me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M12.1429 11v9m0-9c-2.50543-.7107-3.19099-1.39543-6.13657-1.34968-.48057.00746-.86348.38718-.86348.84968v7.2884c0 .4824.41455.8682.91584.8617 2.77491-.0362 3.45995.6561 6.08421 1.3499m0-9c2.5053-.7107 3.1067-1.39542 6.0523-1.34968.4806.00746.9477.38718.9477.84968v7.2884c0 .4824-.4988.8682-1 .8617-2.775-.0362-3.3758.6561-6 1.3499m2-14c0 1.10457-.8955 2-2 2-1.1046 0-2-.89543-2-2s.8954-2 2-2c1.1045 0 2 .89543 2 2Z"/>
                </svg>
                Students
            </button>
        </li>
        <li class="w-full focus-within:z-10" role="presentation">
            <button id="workstation-tab" data-tabs-target="#workstation" type="button" role="tab" aria-controls="workstation" aria-selected="false" class="inline-flex items-center justify-center  w-full text-body bg-neutral-primary-soft border border-default rounded-e-base hover:bg-neutral-secondary-medium hover:text-heading focus:ring-2 focus:ring-neutral-secondary-strong font-medium leading-5 text-sm px-4 py-2.5 focus:outline-none">
                <svg class="w-[19px] h-[19px] me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v1M9 12H4m8 8V9h8v11h-8Zm0 0H9m8-4a1 1 0 1 0-2 0 1 1 0 0 0 2 0Z"/>
                </svg>
                WorkStation Usage
            </button>
        </li>
    </ul>
    <!-- Mobile: dropdown selector for tabs -->
    <div class="block sm:hidden mb-4">
        <label for="analytics-mobile-tabs" class="sr-only">Select analytics tab</label>
        <select id="analytics-mobile-tabs" class="block w-full h-[52px] rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600">
            <option value="all">All</option>
            <option value="students">Students</option>
            <option value="workstation">WorkStation Usage</option>
        </select>
    </div>
    <div id="default-tab-content">
        <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="all" role="tabpanel" aria-labelledby="all-tab">
            <p class="text-sm text-body">This is some placeholder content the <strong class="font-medium text-heading">All tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
        </div>
        <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="students" role="tabpanel" aria-labelledby="students-tab">
            <p class="text-sm text-body">This is some placeholder content the <strong class="font-medium text-heading">Students tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
        </div>
        <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="workstation" role="tabpanel" aria-labelledby="workstation-tab">
            <p class="text-sm text-body">This is some placeholder content the <strong class="font-medium text-heading">WorkStation Usage tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var select = document.getElementById('analytics-mobile-tabs');
            if (!select) return;
            var tabs = document.querySelectorAll('#default-tab button[role="tab"]');
            var active = Array.from(tabs).find(function (t) { return t.getAttribute('aria-selected') === 'true'; });
            if (active) select.value = active.id.replace('-tab', '');

            // when mobile select changes, trigger the corresponding tab
            select.addEventListener('change', function () {
                var val = this.value;
                var btn = document.getElementById(val + '-tab');
                if (btn) btn.click();
            });

            // when desktop tabs are clicked, update the mobile select (two-way sync)
            tabs.forEach(function (t) {
                t.addEventListener('click', function () {
                    var id = t.id.replace('-tab', '');
                    select.value = id;
                });
            });
        });
    </script>

</div>
@endsection
