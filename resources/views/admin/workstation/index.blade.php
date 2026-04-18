@extends('layout.app')

@section('title','Workstation')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

    {{-- CARD 1 --}}
    <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-6">
        {{-- Clickable centered icon --}}
        <div class="flex justify-center mb-6">

           <a
                href="#"
                class="group outline-none"
                aria-label="Open PC 1"
                data-modal-target="default-modal"
                data-modal-toggle="default-modal"
                onclick="event.preventDefault();"
            >
    <div class="w-20 h-20 bg-neutral-primary-medium border border-default-medium rounded-full flex items-center justify-center
                transition-colors group-hover:bg-neutral-tertiary-medium group-focus:ring-4 group-focus:ring-neutral-tertiary">
        <svg class="w-10 h-10 text-body transition-colors group-hover:text-heading" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 17h10M9 20h6M6 16h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z" />
        </svg>
    </div>
</a>
        </div>

        <h5 class="text-xl font-semibold text-heading text-center mb-2">Workstation</h5>
        <p class="text-body text-sm text-center mb-6">Available for use</p>

        <div class="flex items-center justify-between pt-4 border-t border-light">
            <span class="text-body text-sm font-medium">PC 1</span>
            <span class="inline-flex items-center bg-success-soft border border-success-subtle text-fg-success-strong text-sm font-medium px-2 py-1 rounded">
                Active
            </span>
        </div>
    </div>
     {{-- CARD 2 --}}
    <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-6">
        {{-- Clickable centered icon --}}
        <div class="flex justify-center mb-6">
            <a href="#" class="group outline-none" aria-label="Open PC 1">
                <div class="w-20 h-20 bg-neutral-primary-medium border border-default-medium rounded-full flex items-center justify-center
                            transition-colors group-hover:bg-neutral-tertiary-medium group-focus:ring-4 group-focus:ring-neutral-tertiary">
                    <svg class="w-10 h-10 text-body transition-colors group-hover:text-heading" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 17h10M9 20h6M6 16h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z" />
                    </svg>
                </div>
            </a>
        </div>

        <h5 class="text-xl font-semibold text-heading text-center mb-2">Workstation</h5>
        <p class="text-body text-sm text-center mb-6">Available for use</p>

        <div class="flex items-center justify-between pt-4 border-t border-light">
            <span class="text-body text-sm font-medium">PC 2</span>
            <span class="inline-flex items-center bg-success-soft border border-success-subtle text-fg-success-strong text-sm font-medium px-2 py-1 rounded">
                Active
            </span>
        </div>
    </div>

     {{-- CARD 3 --}}
    <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-6">
        {{-- Clickable centered icon --}}
        <div class="flex justify-center mb-6">
            <a href="#" class="group outline-none" aria-label="Open PC 1">
                <div class="w-20 h-20 bg-neutral-primary-medium border border-default-medium rounded-full flex items-center justify-center
                            transition-colors group-hover:bg-neutral-tertiary-medium group-focus:ring-4 group-focus:ring-neutral-tertiary">
                    <svg class="w-10 h-10 text-body transition-colors group-hover:text-heading" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 17h10M9 20h6M6 16h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z" />
                    </svg>
                </div>
            </a>
        </div>

        <h5 class="text-xl font-semibold text-heading text-center mb-2">Workstation</h5>
        <p class="text-body text-sm text-center mb-6">Available for use</p>

        <div class="flex items-center justify-between pt-4 border-t border-light">
            <span class="text-body text-sm font-medium">PC 3</span>
            <span class="inline-flex items-center bg-success-soft border border-success-subtle text-fg-success-strong text-sm font-medium px-2 py-1 rounded">
                Active
            </span>
        </div>
    </div>
</div>


<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">

           <!-- Modal header -->
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <div class="flex items-center gap-3">
                    <!-- PC icon (same as PC1) -->
                    <div class="w-10 h-10 bg-neutral-primary-medium border border-default-medium rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-body" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 17h10M9 20h6M6 16h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z" />
                        </svg>
                    </div>

                    <h3 class="text-lg font-medium text-heading">
                        Workstation Session
                    </h3>
                </div>

                <button type="button"
                    class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="default-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="py-4 md:py-6 space-y-4">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-neutral-secondary-medium border border-default rounded-base p-4">
                        <p class="text-xs text-body">User</p>
                        <p class="text-sm font-semibold text-heading" id="modal-user">John Doe</p>
                    </div>

                    <div class="bg-neutral-secondary-medium border border-default rounded-base p-4">
                        <p class="text-xs text-body">Course</p>
                        <p class="text-sm font-semibold text-heading" id="modal-course">Web Development 101</p>
                    </div>

                    <div class="bg-neutral-secondary-medium border border-default rounded-base p-4">
                        <p class="text-xs text-body">Time elapsed</p>
                        <p class="text-sm font-semibold text-heading" id="modal-elapsed">00:00</p>
                    </div>
                </div>

                <div class="bg-neutral-primary-soft border border-default rounded-base p-4">
                    <p class="text-sm text-body">
                        Session is currently running on this workstation. This is dummy data for UI testing.
                    </p>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="flex items-center border-t border-default space-x-4 pt-4 md:pt-5">
                <button data-modal-hide="default-modal" type="button"
                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
<script>
  (function () {
    let seconds = 0;
    let timerId = null;

    function formatTime(s) {
      const mm = String(Math.floor(s / 60)).padStart(2, '0');
      const ss = String(s % 60).padStart(2, '0');
      return `${mm}:${ss}`;
    }

    function startTimer() {
      stopTimer();
      seconds = 0;
      const elapsedEl = document.getElementById('modal-elapsed');
      if (elapsedEl) elapsedEl.textContent = formatTime(seconds);

      timerId = setInterval(() => {
        seconds++;
        if (elapsedEl) elapsedEl.textContent = formatTime(seconds);
      }, 1000);
    }

    function stopTimer() {
      if (timerId) clearInterval(timerId);
      timerId = null;
    }

    // Flowbite toggles 'hidden' class on the modal. We'll watch that and start/stop timer.
    document.addEventListener('click', function () {
      const modal = document.getElementById('default-modal');
      if (!modal) return;

      // after Flowbite runs, check visibility
      setTimeout(() => {
        const isHidden = modal.classList.contains('hidden');
        if (!isHidden) startTimer();
        else stopTimer();
      }, 0);
    });
  })();
</script>

@endsection
