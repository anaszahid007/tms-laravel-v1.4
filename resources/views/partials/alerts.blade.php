<div x-data="{
    success: '{{ session('success') }}',
    error: '{{ session('error') }}',
    warning: '{{ session('warning') }}',
    showSuccess: {{ session('success') ? 'true' : 'false' }},
    showError: {{ session('error') ? 'true' : 'false' }},
    showWarning: {{ session('warning') ? 'true' : 'false' }}
    }" x-init="if (showSuccess) setTimeout(() => showSuccess = false, 5000);
    if (showError) setTimeout(() => showError = false, 6000);
    if (showWarning) setTimeout(() => showWarning = false, 5000);"
    class="fixed top-20 right-4 md:top-24 flex flex-col gap-4 max-w-sm w-full pointer-events-none z-50 px-4 md:px-0">

    <!-- Success Alert -->
    <template x-if="showSuccess">
        <div x-show="showSuccess" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="pointer-events-auto overflow-hidden bg-white backdrop-blur-sm border-l-4 border-green-500 rounded-xl shadow-2xl p-4 flex items-start gap-4 ring-1 ring-black/10 min-w-[320px]">
            <div
                class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                <i class="fa-solid fa-circle-check text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-gray-900">Success!</h3>
                <p class="text-sm text-gray-600 mt-1" x-text="success"></p>
            </div>
            <button @click="showSuccess = false" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </template>

    <!-- Error Alert -->
    <template x-if="showError">
        <div x-show="showError" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="pointer-events-auto overflow-hidden bg-white backdrop-blur-sm border-l-4 border-red-500 rounded-xl shadow-2xl p-4 flex items-start gap-4 ring-1 ring-black/10 min-w-[320px]">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                <i class="fa-solid fa-circle-xmark text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-gray-900">Error!</h3>
                <p class="text-sm text-gray-600 mt-1" x-text="error"></p>
            </div>
            <button @click="showError = false" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </template>

    <!-- Warning Alert -->
    <template x-if="showWarning">
        <div x-show="showWarning" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="pointer-events-auto overflow-hidden bg-white backdrop-blur-sm border-l-4 border-amber-500 rounded-xl shadow-2xl p-4 flex items-start gap-4 ring-1 ring-black/10 min-w-[320px]">
            <div
                class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-gray-900">Warning</h3>
                <p class="text-sm text-gray-600 mt-1" x-text="warning"></p>
            </div>
            <button @click="showWarning = false" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </template>
</div>