<div id="error-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs px-4">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6 border border-gray-200 transform transition-all">
        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        
        <h3 id="error-modal-title" class="text-lg font-bold text-center text-heading">Security Error</h3>
        
        <p id="error-modal-message" class="mt-2 text-sm text-center text-body">
            {{-- Blade fallback catch for direct session errors --}}
            {{ $slot->isEmpty() ? 'Something went wrong. Please try again.' : $slot }}
        </p>
        
        <div class="mt-6">
            <button type="button" onclick="closeGlobalErrorModal()"
                    class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-base hover:bg-blue-700 transition">
                Try Again
            </button>
        </div>
    </div>
</div>

<script>
    // Global function to trigger the error box from ANY script file or AJAX catch block
    function openGlobalErrorModal(errorMessage = '', errorTitle = 'Security Error') {
        const modal = document.getElementById('error-modal');
        const titleEl = document.getElementById('error-modal-title');
        const msgEl = document.getElementById('error-modal-message');

        if (titleEl && errorTitle) titleEl.textContent = errorTitle;
        if (msgEl && errorMessage) msgEl.textContent = errorMessage;

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeGlobalErrorModal() {
        const modal = document.getElementById('error-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
    {{-- Session Message Listener --}}

    // Backdrop click validation closure
    document.addEventListener('DOMContentLoaded', () => {
        const errModalWrapper = document.getElementById('error-modal');
        if (errModalWrapper) {
            errModalWrapper.addEventListener('click', function(e) {
                if (e.target === errModalWrapper) {
                    closeGlobalErrorModal();
                }
            });
        }
    });
</script>