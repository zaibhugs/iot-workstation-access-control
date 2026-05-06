[@extends('layout.app')

@section('title','Analytics')

@section('content')

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

{{-- ── TABS NAV ── --}}
<ul class="hidden text-sm font-medium text-center text-body sm:flex -space-x-px mb-4"
    id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">

    <li class="w-full focus-within:z-10" role="presentation">
        <button id="all-tab" data-tabs-target="#all" type="button" role="tab"
            aria-controls="all" aria-selected="true"
            class="inline-flex items-center justify-center w-full text-body bg-neutral-primary-soft border border-default rounded-s-base hover:bg-neutral-secondary-medium hover:text-heading focus:ring-2 focus:ring-neutral-secondary-strong font-medium leading-5 text-sm px-4 py-2.5 focus:outline-none">
            <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z"/>
            </svg>
            All
        </button>
    </li>

    <li class="w-full focus-within:z-10" role="presentation">
        <button id="students-tab" data-tabs-target="#students" type="button" role="tab"
            aria-controls="students" aria-selected="false"
            class="inline-flex items-center justify-center w-full text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading focus:ring-2 focus:ring-neutral-secondary-strong font-medium leading-5 text-sm px-4 py-2.5 focus:outline-none">
            <svg class="w-[19px] h-[19px] me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M12.1429 11v9m0-9c-2.50543-.7107-3.19099-1.39543-6.13657-1.34968-.48057.00746-.86348.38718-.86348.84968v7.2884c0 .4824.41455.8682.91584.8617 2.77491-.0362 3.45995.6561 6.08421 1.3499m0-9c2.5053-.7107 3.1067-1.39542 6.0523-1.34968.4806.00746.9477.38718.9477.84968v7.2884c0 .4824-.4988.8682-1 .8617-2.775-.0362-3.3758.6561-6 1.3499m2-14c0 1.10457-.8955 2-2 2-1.1046 0-2-.89543-2-2s.8954-2 2-2c1.1045 0 2 .89543 2 2Z"/>
            </svg>
            Students
        </button>
    </li>

    <li class="w-full focus-within:z-10" role="presentation">
        <button id="workstation-tab" data-tabs-target="#workstation" type="button" role="tab"
            aria-controls="workstation" aria-selected="false"
            class="inline-flex items-center justify-center w-full text-body bg-neutral-primary-soft border border-default rounded-e-base hover:bg-neutral-secondary-medium hover:text-heading focus:ring-2 focus:ring-neutral-secondary-strong font-medium leading-5 text-sm px-4 py-2.5 focus:outline-none">
            <svg class="w-[19px] h-[19px] me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v1M9 12H4m8 8V9h8v11h-8Zm0 0H9m8-4a1 1 0 1 0-2 0 1 1 0 0 0 2 0Z"/>
            </svg>
            WorkStation
        </button>
    </li>
</ul>

{{-- Mobile dropdown --}}
<div class="block sm:hidden mb-4">
    <label for="analytics-mobile-tabs" class="sr-only">Select analytics tab</label>
    <select id="analytics-mobile-tabs"
        class="block w-full h-[52px] rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600">
        <option value="all">All</option>
        <option value="students">Students</option>
        <option value="workstation">WorkStation Usage</option>
    </select>
</div>

{{-- ═══════════════════════════════════════════════
    TAB PANELS
    ═══════════════════════════════════════════════ --}}
<div id="default-tab-content">

    {{-- ─────────────────────────────────────────
        TAB 1 · ALL
        ───────────────────────────────────────── --}}
    <div class="hidden rounded-lg bg-neutral-secondary-soft p-6" id="all" role="tabpanel" aria-labelledby="all-tab">

        {{-- KPI row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Total Access Events</p>
                <p class="text-2xl font-semibold text-heading" id="total-access-events">0</p>
                <p class="text-xs mt-1 text-body" id="total-access-events-sub"></p>
            </div>

            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Granted Rate</p>
                <p class="text-2xl font-semibold text-heading" id="granted-rate">0%</p>
                <p class="text-xs mt-1 text-body" id="granted-rate-sub"></p>
            </div>

            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Unique Students</p>
                <p class="text-2xl font-semibold text-heading" id="unique-students">0</p>
                <p class="text-xs mt-1 text-body" id="unique-students-sub"></p>
            </div>

            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Avg Session Duration</p>
                <p class="text-2xl font-semibold text-heading" id="avg-session-duration">0m</p>
                <p class="text-xs mt-1 text-body" id="avg-session-duration-sub"></p>
            </div>
        </div>

        {{-- Peak hours + Course --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-sm font-medium text-heading mb-3">Peak Usage Hours</p>
                <div class="relative h-44"><canvas id="chartPeak"></canvas></div>
            </div>
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-sm font-medium text-heading mb-3">Access by Course</p>
                <div class="relative h-44"><canvas id="chartCourse"></canvas></div>
            </div>
        </div>
    </div>{{-- /all --}}

    {{-- ─────────────────────────────────────────
        TAB 2 · STUDENTS
        ───────────────────────────────────────── --}}
    <div class="hidden rounded-lg bg-neutral-secondary-soft p-6" id="students" role="tabpanel" aria-labelledby="students-tab">

        {{-- KPIs --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Unique Students</p>
                <p class="text-2xl font-semibold text-heading" id="s-unique-students">0</p>
                <p class="text-xs mt-1 text-body" id="s-unique-students-sub"></p>
            </div>

            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Avg Sessions / Student</p>
                <p class="text-2xl font-semibold text-heading" id="s-avg-sessions-per-student">0</p>
                <p class="text-xs mt-1 text-body" id="s-avg-sessions-per-student-sub"></p>
            </div>

            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Top Course</p>
                <p class="text-2xl font-semibold text-heading" id="s-top-course">-</p>
                <p class="text-xs mt-1 text-body" id="s-top-course-sub"></p>
            </div>
        </div>

        {{-- Charts row --}}
        <div class="mb-4">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-sm font-medium text-heading mb-3">Sessions per Course</p>
                <div class="relative h-48"><canvas id="chartStuCourse"></canvas></div>
            </div>
        </div>

        {{-- Student table --}}
        <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                <p class="text-sm font-medium text-heading">Student Access Log</p>
                <div class="flex gap-2">
                    <input type="text" id="stuSearch" placeholder="Search name or ID…"
                        class="text-sm border border-default rounded-base px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-neutral-secondary-strong w-48 text-body"
                        oninput="filterStudents()">
                    <select id="stuCourse" onchange="filterStudents()"
                        class="text-sm border border-default rounded-base px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-neutral-secondary-strong text-body">
                        <option value="">All courses</option>
                        <option>BSCS</option><option>BSIT</option><option>BSECE</option>
                        <option>BS CpE</option><option>BSIS</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-default text-xs text-body uppercase">
                            <th class="px-3 py-2 font-medium">Student</th>
                            <th class="px-3 py-2 font-medium">Course</th>
                            <th class="px-3 py-2 font-medium text-center">Sessions</th>
                            <th class="px-3 py-2 font-medium text-center">Avg Duration</th>
                            <th class="px-3 py-2 font-medium text-center">Last Access</th>
                            <th class="px-3 py-2 font-medium text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="stuBody" class="divide-y divide-default text-body"></tbody>
                </table>
            </div>
        </div>
    </div>{{-- /students --}}

    {{-- ─────────────────────────────────────────
        TAB 3 · WORKSTATION
        ───────────────────────────────────────── --}}
    <div class="hidden rounded-lg bg-neutral-secondary-soft p-6" id="workstation" role="tabpanel" aria-labelledby="workstation-tab">

        {{-- KPIs --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Total Workstations</p>
                <p class="text-2xl font-semibold text-heading" id="w-total-workstations">0</p>
                <p class="text-xs mt-1 text-body" id="w-total-workstations-sub"></p>
            </div>

            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Most Used</p>
                <p class="text-2xl font-semibold text-heading" id="w-most-used">-</p>
                <p class="text-xs mt-1 text-body" id="w-most-used-sub"></p>
            </div>

            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-xs text-body mb-1">Avg Sessions / Workstation</p>
                <p class="text-2xl font-semibold text-heading" id="w-avg-sessions-per-workstation">0</p>
                <p class="text-xs mt-1 text-body" id="w-avg-sessions-per-workstation-sub"></p>
            </div>
        </div>

        {{-- Charts row 1 --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-sm font-medium text-heading mb-3">Sessions per Workstation</p>
                <div class="relative h-56"><canvas id="chartWsSessions"></canvas></div>
            </div>
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <p class="text-sm font-medium text-heading mb-3">Avg Session Duration per Workstation</p>
                <div class="relative h-56"><canvas id="chartWsDuration"></canvas></div>
            </div>
        </div>
    </div>{{-- /workstation --}}

</div>{{-- /default-tab-content --}}


{{-- ═══════════════════════════════════════════════
    SCRIPTS
    ═══════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── mobile-tab sync ── */
    var select = document.getElementById('analytics-mobile-tabs');
    var tabs   = document.querySelectorAll('#default-tab button[role="tab"]');
    var active = Array.from(tabs).find(t => t.getAttribute('aria-selected') === 'true');
    if (active && select) select.value = active.id.replace('-tab', '');
    if (select) {
        select.addEventListener('change', function () {
            var btn = document.getElementById(this.value + '-tab');
            if (btn) btn.click();
        });
        tabs.forEach(t => t.addEventListener('click', function () {
            select.value = t.id.replace('-tab', '');
        }));
    }

    /* ── shared palette ── */
    const BLUE  = '#2563eb';
    const RED   = '#ef4444';
    const LBLUE = 'rgba(37,99,235,0.12)';
    const grid  = { color: 'rgba(0,0,0,0.06)' };
    const font  = { size: 11, family: 'inherit' };
    const noLegend = { legend: { display: false } };
    const axisX = (stacked = false) => ({
        stacked, grid: { display: false }, ticks: { font, maxRotation: 45, autoSkip: true, maxTicksLimit: 7 }
    });
    const axisY = (stacked = false, cb = null) => ({
        stacked, grid, ticks: { font, callback: cb ?? undefined }
    });

    /* ════════════ ALL TAB ════════════ */
    const hours = [];
    const peakPts = [];
    new Chart(document.getElementById('chartPeak'), {
        type: 'line',
        data: { labels: hours, datasets:[{ data: peakPts, borderColor: BLUE, backgroundColor: LBLUE,
            fill:true, tension:0.4, pointRadius:3 }] },
        options: { responsive:true, maintainAspectRatio:false, plugins: noLegend,
            scales: { x: axisX(), y: axisY() } }
    });

    new Chart(document.getElementById('chartCourse'), {
        type: 'bar',
        data: { labels:[], datasets:[{ data:[], backgroundColor: BLUE, borderRadius:3 }] },
        options: { responsive:true, maintainAspectRatio:false, plugins: noLegend,
            scales: { x: axisX(), y: axisY() } }
    });

    /* ════════════ STUDENTS TAB ════════════ */
    new Chart(document.getElementById('chartStuCourse'), {
        type: 'bar',
        data: { labels:[], datasets:[{ data:[], backgroundColor:[], borderRadius:3 }] },
        options: { responsive:true, maintainAspectRatio:false, plugins: noLegend,
            scales: { x: axisX(), y: axisY() } }
    });

    /* Student table */
    const allStudents = [];

    function renderStudents(list) {
        const tbody = document.getElementById('stuBody');
        if (!tbody) return;
        tbody.innerHTML = '';
        list.forEach(s => {
            const on = s.status === 'active';
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-3 py-2.5">
                    <span class="font-medium text-heading block">${s.name}</span>
                    <span class="text-xs text-body">${s.id}</span>
                </td>
                <td class="px-3 py-2.5 text-body">${s.course}</td>
                <td class="px-3 py-2.5 text-center text-heading">${s.sessions}</td>
                <td class="px-3 py-2.5 text-center text-body">${s.avg}</td>
                <td class="px-3 py-2.5 text-center text-body">${s.last}</td>
                <td class="px-3 py-2.5 text-center">
                    <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full
                        ${on ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'}">
                        <span class="w-1.5 h-1.5 rounded-full ${on ? 'bg-green-500' : 'bg-gray-400'}"></span>
                        ${s.status}
                    </span>
                </td>`;
            tbody.appendChild(tr);
        });
    }

    window.filterStudents = function () {
        const q = (document.getElementById('stuSearch')?.value ?? '').toLowerCase();
        const c = document.getElementById('stuCourse')?.value ?? '';
        renderStudents(allStudents.filter(s =>
            (!q || s.name.toLowerCase().includes(q) || s.id.includes(q)) && (!c || s.course === c)
        ));
    };
    renderStudents(allStudents);

    /* ════════════ WORKSTATION TAB ════════════ */
    const wsCodes = [];
    const wsSessions = [];
    const wsDuration = [];

    new Chart(document.getElementById('chartWsSessions'), {
        type: 'bar',
        data: { labels: wsCodes, datasets:[{ data: wsSessions, backgroundColor: BLUE, borderRadius:3 }] },
        options: { indexAxis:'y', responsive:true, maintainAspectRatio:false, plugins: noLegend,
            scales: { x: axisY(), y: { grid:{ display:false }, ticks:{ font } } } }
    });

    new Chart(document.getElementById('chartWsDuration'), {
        type: 'bar',
        data: { labels: wsCodes, datasets:[{ data: wsDuration, backgroundColor:'#60a5fa', borderRadius:3 }] },
        options: { responsive:true, maintainAspectRatio:false, plugins: noLegend,
            scales: { x: axisX(), y: axisY(false, v => v+'m') } }
    });

});
</script>

@endsection
]
