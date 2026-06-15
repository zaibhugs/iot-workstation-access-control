@if(session('pairing_success'))
    <div id="toast-illustration" class="w-full space-y-4 max-w-sm p-3 bg-white rounded-xl shadow-lg border border-gray-200 fixed bottom-5 right-5 z-50 transition-all duration-300" role="alert">
        <div class="flex items-start">

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0110 21a3.745 3.745 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.745 3.745 0 013.296-1.043A3.745 3.745 0 0114 3c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 013.296 1.043 3.745 3.745 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
            </div>
            

            <div class="ms-4 text-sm font-normal text-gray-600">
                <span class="mb-1 text-base font-semibold text-gray-900 block">Device Paired Successfully</span>
                <div class="mb-3 text-gray-500 leading-relaxed">
                    A hardware client has successfully used a validation pairing token. You can now inspect its connection status and resource slots.
                </div> 
                
                <div class="grid grid-cols-2 gap-3">
                    
                    <button 
                        type="button" 
                        onclick="closeToastNotification()" 
                        class="w-full text-gray-700 bg-gray-50 border border-gray-200 hover:bg-gray-100 font-medium rounded-lg text-xs px-3 py-2 transition-colors focus:outline-none"
                    >
                        Not now
                    </button>
                    
                    {{-- Navigation Action (Directly links to the target device detailed view page) --}}
                    <a 
                    href="{{ session('paired_device_id') ? route('device.edit', session('paired_device_id')) : route('device') }}"
                        class="w-full inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-xs px-3 py-2 transition-colors focus:outline-none"
                    >
                        <svg class="w-3.5 h-3.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        View Device
                    </a> 
                </div>     
            </div>
        </div>
    </div>

    {{-- Script Scope to close toast --}}
    <script>
        function closeToastNotification() {
            const toast = document.getElementById('toast-illustration');
            if (toast) {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }
        }
    </script>
@endif