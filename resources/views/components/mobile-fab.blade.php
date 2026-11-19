{{--
    Mobile-only floating action button.

    Shows on pages that have a create action, in place of the desktop
    header button. Sits just above the bottom navigation.

        <x-mobile-fab :href="route('device.create')" label="Add Device" />
--}}

@props([
    'href',
    'label' => 'Add',
    'icon' => 'plus',
])

<a
    href="{{ $href }}"
    class="fixed bottom-[calc(5.25rem+env(safe-area-inset-bottom))] right-4 z-40 inline-flex h-14 items-center gap-2 rounded-full bg-blue-600 px-5 text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition active:scale-95 md:hidden"
    aria-label="{{ $label }}"
>

    <x-icon :name="$icon" class="h-5 w-5" aria-hidden="true" />

    <span>{{ $label }}</span>

</a>
