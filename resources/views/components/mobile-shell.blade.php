{{--
    Mobile app shell (below 768px / md).

    Renders the compact app bar, the native-style bottom navigation,
    and the "More" bottom sheet. Hidden entirely on md and up, where
    the desktop sidebar and full navbar take over.

    Usage (already in layout.app):

        <x-mobile-shell :title="$__env->yieldContent('title', 'Dashboard')" />
--}}

@props(['title' => 'Dashboard'])

@php
    // Home is intentionally the third (centre) tab.
    $navItems = [
        [
            'label' => 'Devices',
            'icon' => 'laptop',
            'href' => route('device'),
            'active' => request()->routeIs('device*'),
        ],
        [
            'label' => 'Analytics',
            'icon' => 'chart-vertical',
            'href' => route('analytics'),
            'active' => request()->routeIs('analytics'),
        ],
        [
            'label' => 'Home',
            'icon' => 'home',
            'href' => route('dashboard'),
            'active' => request()->routeIs('dashboard'),
            'center' => true,
        ],
        [
            'label' => 'Reports',
            'icon' => 'file',
            'href' => route('reports.index'),
            'active' => request()->routeIs('reports*'),
        ],
    ];

    $moreActive = request()->routeIs('monitoring*')
        || request()->routeIs('user.*')
        || request()->routeIs('settings.*')
        || request()->routeIs('account');

    $avatar = Auth::user()->profile_picture
        ? asset('storage/' . Auth::user()->profile_picture)
        : asset('image/default_user.png');
@endphp


{{-- =========================================================
    APP BAR
========================================================== --}}
<header
    class="fixed inset-x-0 top-0 z-50 border-b border-gray-200 bg-white/90 backdrop-blur-md md:hidden"
>

    <div class="flex h-14 items-center gap-3 px-4">

        <a
            href="{{ route('dashboard') }}"
            class="flex min-w-0 items-center gap-2.5"
            aria-label="Open Learning Hub dashboard"
        >

            <img
                src="{{ asset('image/library_logo.jpg') }}"
                class="h-8 w-8 shrink-0 rounded-lg object-cover ring-1 ring-gray-100"
                alt="Southern Leyte State University logo"
            >


            <span class="truncate text-sm font-bold tracking-tight text-gray-900">
                {{ $title }}
            </span>

        </a>


        {{-- Install app (hidden once running in standalone mode) --}}
        <button
            type="button"
            data-mobile-install
            class="ml-auto flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-blue-600 transition active:bg-blue-50"
            aria-label="Install app"
        >

            <x-icon name="download" class="h-5 w-5" />

        </button>


        <button
            type="button"
            data-mobile-more-open
            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl ring-2 ring-gray-100 transition active:scale-95"
            aria-label="Open menu"
            aria-controls="mobileMoreSheet"
        >

            <img
                src="{{ $avatar }}"
                class="h-full w-full rounded-xl object-cover"
                alt="{{ Auth::user()->name }}"
            >

        </button>

    </div>

</header>


{{-- =========================================================
    BOTTOM NAVIGATION
========================================================== --}}
<nav
    class="fixed inset-x-0 bottom-0 z-50 border-t border-gray-200 bg-white/95 backdrop-blur-md md:hidden"
    aria-label="Mobile navigation"
>

    <div class="grid grid-cols-5 pb-[env(safe-area-inset-bottom)]">

        @foreach($navItems as $item)

            @if(!empty($item['center']))

                {{-- Raised centre tab --}}
                <a
                    href="{{ $item['href'] }}"
                    @if($item['active']) aria-current="page" @endif
                    class="relative flex select-none flex-col items-center justify-center gap-0.5 py-2 text-[10px] font-semibold transition
                    {{ $item['active'] ? 'text-blue-600' : 'text-gray-400 active:text-gray-600' }}"
                >

                    <span
                        class="absolute -top-5 flex h-12 w-12 items-center justify-center rounded-full bg-blue-600 text-white shadow-lg shadow-blue-600/30 ring-4 ring-white transition active:scale-95"
                    >

                        <x-icon :name="$item['icon']" class="h-6 w-6" />

                    </span>


                    {{-- Keeps the label aligned with the other tabs --}}
                    <span class="h-7"></span>


                    <span>{{ $item['label'] }}</span>

                </a>

            @else

                <a
                    href="{{ $item['href'] }}"
                    @if($item['active']) aria-current="page" @endif
                    class="flex select-none flex-col items-center justify-center gap-0.5 py-2 text-[10px] font-semibold transition
                    {{ $item['active'] ? 'text-blue-600' : 'text-gray-400 active:text-gray-600' }}"
                >

                    <span
                        class="flex h-7 w-12 items-center justify-center rounded-full transition
                        {{ $item['active'] ? 'bg-blue-50' : '' }}"
                    >

                        <x-icon :name="$item['icon']" class="h-5 w-5" />

                    </span>


                    <span>{{ $item['label'] }}</span>

                </a>

            @endif

        @endforeach


        {{-- More --}}
        <button
            type="button"
            data-mobile-more-open
            aria-controls="mobileMoreSheet"
            class="flex select-none flex-col items-center justify-center gap-0.5 py-2 text-[10px] font-semibold transition
            {{ $moreActive ? 'text-blue-600' : 'text-gray-400 active:text-gray-600' }}"
        >

            <span
                class="flex h-7 w-12 items-center justify-center rounded-full transition
                {{ $moreActive ? 'bg-blue-50' : '' }}"
            >

                <x-icon name="dots-horizontal" class="h-5 w-5" />

            </span>


            <span>More</span>

        </button>

    </div>

</nav>


{{-- =========================================================
    MORE BOTTOM SHEET
========================================================== --}}
<div
    id="mobileMoreBackdrop"
    class="fixed inset-0 z-[55] hidden bg-gray-900/40 opacity-0 transition-opacity duration-200 md:hidden"
    data-mobile-more-close
    aria-hidden="true"
></div>


<div
    id="mobileMoreSheet"
    class="fixed inset-x-0 bottom-0 z-[60] hidden max-h-[85vh] translate-y-full overflow-y-auto rounded-t-3xl bg-white shadow-2xl transition-transform duration-300 ease-out md:hidden"
    role="dialog"
    aria-modal="true"
    aria-label="More menu"
>

    {{-- Drag handle --}}
    <div class="flex justify-center pb-1 pt-2.5">

        <span class="h-1 w-10 rounded-full bg-gray-200"></span>

    </div>


    {{-- Signed-in user --}}
    <div class="flex items-center gap-3 border-b border-gray-100 px-5 pb-4 pt-2">

        <img
            src="{{ $avatar }}"
            class="h-10 w-10 shrink-0 rounded-xl object-cover ring-2 ring-gray-100"
            alt="{{ Auth::user()->name }}"
        >


        <div class="min-w-0 flex-1">

            <p class="truncate text-sm font-semibold text-gray-900">
                {{ Auth::user()->name }}
            </p>

            <p class="truncate text-xs text-gray-500">
                {{ Auth::user()->email }}
            </p>

        </div>


        <button
            type="button"
            data-mobile-more-close
            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-gray-400 transition active:bg-gray-100"
            aria-label="Close menu"
        >

            <x-icon name="cancel" class="h-5 w-5" />

        </button>

    </div>


    {{-- Links --}}
    <div class="space-y-1 p-3 pb-[calc(1rem+env(safe-area-inset-bottom))]">

        {{-- Install app --}}
        <button
            type="button"
            data-mobile-install
            class="flex w-full items-center gap-3 rounded-xl bg-blue-50 px-3 py-3 text-left transition active:bg-blue-100"
        >

            <span
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white"
            >

                <x-icon name="download" class="h-5 w-5" />

            </span>


            <span class="min-w-0 flex-1">

                <span class="block text-sm font-semibold text-blue-700">
                    Install app
                </span>

                <span class="block text-[11px] text-blue-600/80">
                    Add to home screen
                </span>

            </span>


            <x-icon name="arrow-right" class="h-4 w-4 shrink-0 text-blue-500" />

        </button>


        <div class="mx-3 h-px bg-gray-100"></div>


        {{-- Event Logs --}}
        <a
            href="{{ route('monitoring') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
            {{ request()->routeIs('monitoring*')
                ? 'bg-blue-50 text-blue-600'
                : 'text-gray-700 active:bg-gray-50' }}"
        >

            <span
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                {{ request()->routeIs('monitoring*')
                    ? 'bg-blue-100 text-blue-600'
                    : 'bg-gray-100 text-gray-500' }}"
            >

                <x-icon name="chart" class="h-5 w-5" />

            </span>

            Event Logs

        </a>


        @if(auth()->user()->isSuperAdmin())

            {{-- Users --}}
            <a
                href="{{ route('user') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('user.*')
                    ? 'bg-blue-50 text-blue-600'
                    : 'text-gray-700 active:bg-gray-50' }}"
            >

                <span
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                    {{ request()->routeIs('user.*')
                        ? 'bg-blue-100 text-blue-600'
                        : 'bg-gray-100 text-gray-500' }}"
                >

                    <x-icon name="users" class="h-5 w-5" />

                </span>

                Users

            </a>


            {{-- System Settings --}}
            <a
                href="{{ route('settings.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('settings.*')
                    ? 'bg-blue-50 text-blue-600'
                    : 'text-gray-700 active:bg-gray-50' }}"
            >

                <span
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                    {{ request()->routeIs('settings.*')
                        ? 'bg-blue-100 text-blue-600'
                        : 'bg-gray-100 text-gray-500' }}"
                >

                    <x-icon name="settings" class="h-5 w-5" />

                </span>

                System Settings

            </a>

        @endif


        {{-- Manage Account --}}
        <a
            href="{{ route('account') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
            {{ request()->routeIs('account')
                ? 'bg-blue-50 text-blue-600'
                : 'text-gray-700 active:bg-gray-50' }}"
        >

            <span
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                {{ request()->routeIs('account')
                    ? 'bg-blue-100 text-blue-600'
                    : 'bg-gray-100 text-gray-500' }}"
            >

                <x-icon name="user-plus" class="h-5 w-5" />

            </span>

            Manage Account

        </a>


        {{-- Sign out --}}
        <a
            href="{{ route('logout') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-red-600 transition active:bg-red-50"
        >

            <span
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-500"
            >

                <x-icon name="logout" class="h-5 w-5" />

            </span>

            Sign out

        </a>

    </div>

</div>


{{-- =========================================================
    INSTALL GUIDE
    Shown when the browser cannot offer a native install prompt
    (for example, the site is served over plain HTTP on the LAN).
========================================================== --}}
<div
    id="mobileInstallHint"
    class="fixed inset-x-4 bottom-[calc(5.25rem+env(safe-area-inset-bottom))] z-[70] hidden rounded-2xl bg-gray-900 px-4 py-3 text-white shadow-xl md:hidden"
    role="status"
>

    <div class="flex items-start gap-3">

        <div class="min-w-0 flex-1">

            <p id="mobileInstallHintTitle" class="text-xs font-semibold">
                Preparing install…
            </p>

            <p id="mobileInstallHintText" class="mt-1 text-[11px] leading-4 text-gray-300">
                Waiting for the browser install dialog.
            </p>

        </div>


        <button
            type="button"
            data-mobile-install-hint-close
            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-gray-400 transition active:bg-white/10"
            aria-label="Dismiss"
        >

            <x-icon name="cancel" class="h-4 w-4" />

        </button>

    </div>

</div>


@push('scripts')

    <script>
        (function () {
            var sheet = document.getElementById('mobileMoreSheet');
            var backdrop = document.getElementById('mobileMoreBackdrop');

            if (!sheet || !backdrop) {
                return;
            }

            var closeTimer = null;

            function openSheet() {
                clearTimeout(closeTimer);

                backdrop.classList.remove('hidden');
                sheet.classList.remove('hidden');

                // Next frame so the transition actually runs.
                requestAnimationFrame(function () {
                    backdrop.classList.remove('opacity-0');
                    sheet.classList.remove('translate-y-full');
                });

                document.body.style.overflow = 'hidden';
            }

            function closeSheet() {
                backdrop.classList.add('opacity-0');
                sheet.classList.add('translate-y-full');

                document.body.style.overflow = '';

                closeTimer = setTimeout(function () {
                    backdrop.classList.add('hidden');
                    sheet.classList.add('hidden');
                }, 300);
            }

            document.querySelectorAll('[data-mobile-more-open]').forEach(function (el) {
                el.addEventListener('click', openSheet);
            });

            document.querySelectorAll('[data-mobile-more-close]').forEach(function (el) {
                el.addEventListener('click', closeSheet);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeSheet();
                }
            });

            // Close when the viewport grows into desktop mode.
            window.matchMedia('(min-width: 768px)').addEventListener('change', function (event) {
                if (event.matches) {
                    closeSheet();
                }
            });


            // -------------------------------------------------
            // INSTALL APP
            // Chrome / Brave decide whether an install dialog is
            // allowed. When it is, call prompt() immediately. If the
            // event has not fired yet, wait for it instead of showing
            // instructions right away.
            // -------------------------------------------------
            var installButtons = document.querySelectorAll('[data-mobile-install]');
            var installHint = document.getElementById('mobileInstallHint');
            var installHintTitle = document.getElementById('mobileInstallHintTitle');
            var installHintText = document.getElementById('mobileInstallHintText');
            var hintClose = document.querySelector('[data-mobile-install-hint-close]');
            var deferredPrompt = null;
            var installPending = false;
            var installTimer = null;

            var alreadyInstalled = window.matchMedia('(display-mode: standalone)').matches
                || window.navigator.standalone === true;

            function setInstallVisibility(visible) {
                installButtons.forEach(function (el) {
                    if (visible) {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                    }
                });
            }

            function showHint(title, text) {
                if (!installHint) {
                    return;
                }

                if (installHintTitle) {
                    installHintTitle.textContent = title;
                }

                if (installHintText) {
                    installHintText.textContent = text;
                }

                installHint.classList.remove('hidden');
            }

            function hideHint() {
                if (installHint) {
                    installHint.classList.add('hidden');
                }
            }

            function runInstallPrompt() {
                var prompt = deferredPrompt;
                deferredPrompt = null;
                installPending = false;
                clearTimeout(installTimer);

                closeSheet();
                hideHint();

                if (prompt) {
                    prompt.prompt();
                    if (prompt.userChoice) {
                        prompt.userChoice.then(function () {}).catch(function () {});
                    }
                }
            }

            if (alreadyInstalled) {
                setInstallVisibility(false);
            }

            window.addEventListener('beforeinstallprompt', function (event) {
                event.preventDefault();
                deferredPrompt = event;
                setInstallVisibility(true);

                // The user tapped Install before the browser was ready.
                if (installPending) {
                    runInstallPrompt();
                }
            });

            window.addEventListener('appinstalled', function () {
                deferredPrompt = null;
                installPending = false;
                clearTimeout(installTimer);
                setInstallVisibility(false);
                hideHint();
            });

            installButtons.forEach(function (el) {
                el.addEventListener('click', function () {
                    if (deferredPrompt) {
                        runInstallPrompt();
                        return;
                    }

                    installPending = true;
                    hideHint();
                    showHint(
                        'Preparing install…',
                        'Waiting for the browser install dialog.'
                    );

                    clearTimeout(installTimer);
                    installTimer = setTimeout(function () {
                        if (!installPending) {
                            return;
                        }

                        installPending = false;

                        if (!window.isSecureContext) {
                            showHint(
                                'Automatic install is blocked',
                                'This page is open over HTTP. Chrome and Brave only show the install dialog on HTTPS or localhost.'
                            );
                        } else {
                            showHint(
                                'Browser did not offer install',
                                'Open the browser menu and choose Install app or Add to Home screen.'
                            );
                        }
                    }, 8000);
                });
            });

            if (hintClose && installHint) {
                hintClose.addEventListener('click', function () {
                    installPending = false;
                    clearTimeout(installTimer);
                    hideHint();
                });
            }
        })();
    </script>

@endpush
