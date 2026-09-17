@if (session('success') || session('error'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 4500)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        style="display: none;"
        class="fixed top-5 right-5 z-[60] w-full max-w-sm"
    >
        @if (session('success'))
            <div class="flex items-start gap-3 bg-white border border-mist-200 shadow-lifted rounded-2xl p-4">
                <div class="w-8 h-8 rounded-full bg-success-50 text-success-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="text-sm text-dusk-900 font-medium leading-snug pt-1">{{ session('success') }}</p>
                <button @click="show = false" class="ml-auto text-dusk-400 hover:text-dusk-700 shrink-0">&times;</button>
            </div>
        @elseif (session('error'))
            <div class="flex items-start gap-3 bg-white border border-mist-200 shadow-lifted rounded-2xl p-4">
                <div class="w-8 h-8 rounded-full bg-danger-50 text-danger-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <p class="text-sm text-dusk-900 font-medium leading-snug pt-1">{{ session('error') }}</p>
                <button @click="show = false" class="ml-auto text-dusk-400 hover:text-dusk-700 shrink-0">&times;</button>
            </div>
        @endif
    </div>
@endif