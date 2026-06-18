<div id="verification-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-md rounded-lg border border-gray-200 bg-white p-6 shadow-xl">
        <div class="mb-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-body">Verification Required</p>
            <h3 class="mt-2 text-lg font-bold text-heading">Enter the 6-digit code</h3>
            <p class="mt-2 text-sm text-body">We sent a code to your email. Enter it here to finish saving your password change.</p>
        </div>

        <div id="send-code-feedback" class="mb-4 hidden rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"></div>

        <label for="verification_code_input" class="mb-2 block text-sm font-medium text-heading">Verification Code</label>
        
        {{-- FIXED: Guaranteed clean, separated individual box styles --}}
        <div class="relative w-[288px] h-12 mx-auto my-6">
            <input 
                id="verification_code_input" 
                type="text" 
                inputmode="numeric" 
                maxlength="6" 
                pattern="[0-9]*"
                autocomplete="one-time-code"
                class="absolute inset-0 w-full h-full opacity-0 cursor-text z-10"
                placeholder=""
            >
            
            <div id="fake-boxes-container" class="absolute inset-0 flex justify-between pointer-events-none">
                <div class="w-10 h-12 border border-gray-300 rounded-md bg-gray-50 flex items-center justify-center text-xl font-bold text-heading font-mono"></div>
                <div class="w-10 h-12 border border-gray-300 rounded-md bg-gray-50 flex items-center justify-center text-xl font-bold text-heading font-mono"></div>
                <div class="w-10 h-12 border border-gray-300 rounded-md bg-gray-50 flex items-center justify-center text-xl font-bold text-heading font-mono"></div>
                <div class="w-10 h-12 border border-gray-300 rounded-md bg-gray-50 flex items-center justify-center text-xl font-bold text-heading font-mono"></div>
                <div class="w-10 h-12 border border-gray-300 rounded-md bg-gray-50 flex items-center justify-center text-xl font-bold text-heading font-mono"></div>
                <div class="w-10 h-12 border border-gray-300 rounded-md bg-gray-50 flex items-center justify-center text-xl font-bold text-heading font-mono"></div>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="button" id="close-verification-modal" class="flex-1 rounded-base border border-default px-4 py-2.5 text-sm font-medium text-heading hover:bg-neutral-secondary-medium transition">Cancel</button>
            <button type="button" id="confirm-save-button" class="flex-1 rounded-base bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 transition">Confirm &amp; Save</button>
        </div>
    </div>
</div>

<script>
    const realInput = document.getElementById('verification_code_input');
    const fakeBoxesContainer = document.getElementById('fake-boxes-container');
    const fakeBoxes = fakeBoxesContainer ? fakeBoxesContainer.children : [];

    // Sync typing from hidden input to visible separated boxes
    if (realInput) {
        realInput.addEventListener('input', function() {
            // Clean up input value to only allow digits
            this.value = this.value.replace(/[^0-9]/g, '');
            const digits = this.value.split('');

            for (let i = 0; i < fakeBoxes.length; i++) {
                if (digits[i]) {
                    fakeBoxes[i].textContent = digits[i];
                    fakeBoxes[i].classList.add('border-blue-600', 'ring-1', 'ring-blue-600', 'bg-white');
                    fakeBoxes[i].classList.remove('border-gray-300', 'bg-gray-50');
                } else {
                    fakeBoxes[i].textContent = '';
                    fakeBoxes[i].classList.remove('border-blue-600', 'ring-1', 'ring-blue-600', 'bg-white');
                    fakeBoxes[i].classList.add('border-gray-300', 'bg-gray-50');
                }
            }
        });
    }

    function openVerificationModal() {
        const modal = document.getElementById('verification-modal');
        const feedback = document.getElementById('send-code-feedback');

        if (feedback) {
            feedback.classList.add('hidden');
            feedback.textContent = '';
        }
        
        if (realInput) {
            realInput.value = '';
            // Trigger input event clear state
            realInput.dispatchEvent(new Event('input'));
        }

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => realInput.focus(), 150);
        }
    }

    function closeVerificationModal() {
        const modal = document.getElementById('verification-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const closeBtn = document.getElementById('close-verification-modal');
        const modalWrapper = document.getElementById('verification-modal');

        if (closeBtn) {
            closeBtn.addEventListener('click', closeVerificationModal);
        }

        if (modalWrapper) {
            modalWrapper.addEventListener('click', function (event) {
                if (event.target === modalWrapper) {
                    closeVerificationModal();
                }
            });
        }
    });
</script>