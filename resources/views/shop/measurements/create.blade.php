@extends('layouts.shop')

@section('header', 'New Measurement')

@section('content')
    <div class="max-w-6xl mx-auto" dir="{{ $language === 'ur' ? 'rtl' : 'ltr' }}">

        <div class="mb-6 flex justify-between items-center {{ $language === 'ur' ? 'flex-row-reverse' : '' }}">
            <a href="{{ route('customers.show', $customer_id ?? request('customer_id')) }}"
                class="text-gray-500 hover:text-indigo-600 transition flex items-center gap-2 {{ $language === 'ur' ? 'flex-row-reverse' : '' }}">
                <i class="fa-solid fa-arrow-{{ $language === 'ur' ? 'right' : 'left' }}"></i> 
                {{ $language === 'ur' ? 'گاہک کی طرف واپس جائیں' : 'Back to Customer' }}
            </a>
            
            <!-- Language Switcher -->
            <div class="flex items-center gap-2 {{ $language === 'ur' ? 'flex-row-reverse' : '' }}">
                <span class="text-sm text-gray-600">{{ $language === 'ur' ? 'زبان:' : 'Language:' }}</span>
                <div class="flex bg-gray-100 rounded-lg p-1">
                    <a href="?{{ http_build_query(array_merge(request()->query(), ['lang' => 'en'])) }}"
                        class="px-3 py-1 text-sm rounded-md transition {{ $language === 'en' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        English
                    </a>
                    <a href="?{{ http_build_query(array_merge(request()->query(), ['lang' => 'ur'])) }}"
                        class="px-3 py-1 text-sm rounded-md transition {{ $language === 'ur' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        اردو
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-200">
            <div class="bg-indigo-600 px-8 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-2xl flex items-center gap-3">
                            <i class="fa-solid fa-ruler-combined"></i> 
                            {{ $language === 'ur' ? 'پیمائش ریکارڈ کریں' : 'Record Measurements' }}
                        </h3>
                        <p class="text-indigo-100 text-sm mt-2 font-medium">
                            {{ $language === 'ur' ? 'گاہک: ' . $customer->name : 'Customer: ' . $customer->name }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('measurements.store') }}" id="measurement-form">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customer_id ?? request('customer_id') }}">
                    <input type="hidden" name="language" value="{{ $language }}">

                    <!-- Measurement Type & Basic Info -->
                    <div class="mb-10 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="type" class="block text-xl font-bold text-gray-800 mb-3 {{ $language === 'ur' ? 'text-right' : '' }}">
                                    {{ $language === 'ur' ? 'پیمائش کی قسم' : 'Measurement Type' }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 {{ $language === 'ur' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none text-gray-400">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <input type="text" id="type" name="type" required
                                        class="block w-full {{ $language === 'ur' ? 'pr-10 text-right' : 'pl-10' }} border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-lg py-4 transition-all"
                                        placeholder="{{ $language === 'ur' ? 'مثلاً: قمیض شلوار، پینٹ کوٹ...' : 'e.g. Shalwar Kameez, Pant Coat...' }}"
                                        value="{{ old('type', $language === 'ur' ? 'قمیض شلوار' : 'Shalwar Kameez') }}">
                                </div>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-end">
                                <div class="w-full p-4 bg-indigo-50 rounded-xl border border-indigo-100 flex items-center gap-4 {{ $language === 'ur' ? 'flex-row-reverse text-right' : '' }}">
                                    <div class="w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xl shadow-sm">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-wider text-indigo-600 font-bold">{{ $language === 'ur' ? 'منتخب گاہک' : 'Selected Customer' }}</p>
                                        <p class="text-lg font-black text-indigo-900">{{ $customer->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Standard Measurement Fields -->
                    <div id="measurement-fields" class="mb-10 transition-all duration-300">
                        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm transition-all">
                            <div class="flex items-center justify-between mb-8 {{ $language === 'ur' ? 'flex-row-reverse' : '' }}">
                                <h4 class="text-2xl font-bold text-gray-900 flex items-center gap-3 {{ $language === 'ur' ? 'flex-row-reverse' : '' }}">
                                    <i class="fa-solid fa-list-check text-indigo-600"></i>
                                    {{ $language === 'ur' ? 'پیمائش کی تفصیلات' : 'Measurement Details' }}
                                </h4>
                                <button type="button" onclick="addNewField()" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 rounded-xl font-bold text-sm transition-all shadow-sm">
                                    <i class="fa-solid fa-plus-circle"></i>
                                    {{ $language === 'ur' ? 'نیا فیلڈ شامل کریں' : 'Add New Field' }}
                                </button>
                            </div>
                            
                            <div id="fields-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                                @foreach($standardFields as $index => $field)
                                    <div class="space-y-3 group">
                                        <label for="data_{{ $field['name'] }}" class="block text-base font-bold text-gray-700 transition-colors group-hover:text-indigo-600 {{ $language === 'ur' ? 'text-right' : '' }}">
                                            {{ $language === 'ur' ? $field['label_ur'] : $field['label'] }}
                                            <span class="text-xs font-medium text-gray-400">({{ $field['unit'] }})</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text" 
                                                   name="data[{{ $field['name'] }}]" 
                                                   id="data_{{ $field['name'] }}"
                                                   value="{{ old('data.' . $field['name']) }}"
                                                   class="block w-full border-2 border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-center font-black text-2xl py-4 transition-all"
                                                   placeholder="0.0"
                                                   tabindex="{{ $index + 1 }}"
                                                   onkeydown="handleKeydown(event, {{ $index }})">
                                        </div>

                                        @error('data.' . $field['name'])
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-10">
                        <label for="notes" class="block text-lg font-bold text-gray-800 mb-3 {{ $language === 'ur' ? 'text-right' : '' }}">
                            {{ $language === 'ur' ? 'خاص ہدایات / نوٹ' : 'Special Instructions / Notes' }}
                        </label>
                        <textarea id="notes" name="notes" rows="4"
                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-lg p-4 {{ $language === 'ur' ? 'text-right' : '' }}"
                            placeholder="{{ $language === 'ur' ? 'مثلاً: سلیم فٹ، ڈھیلا کالر، یا کوئی اور خاص ہدایت...' : 'e.g. Slim fit, loose collar, or any other specific instruction...' }}"></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-8 border-t border-gray-100 {{ $language === 'ur' ? 'flex-row-reverse' : '' }}">
                        <div class="flex items-center gap-4">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="save_and_add_another" class="w-6 h-6 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                                <span class="mx-3 text-lg font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">
                                    {{ $language === 'ur' ? 'محفوظ کریں اور دوسرا ریکارڈ کریں' : 'Save & Add Another' }}
                                </span>
                            </label>
                        </div>

                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <button type="submit" 
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-10 py-5 bg-indigo-600 border border-transparent rounded-xl font-bold text-lg text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition-all shadow-lg shadow-indigo-500/20">
                                <i class="fa-solid fa-save text-xl"></i> 
                                {{ $language === 'ur' ? 'پیمائش محفوظ کریں' : 'Save Measurement' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const language = '{{ $language }}';
        const STORAGE_KEY = 'tailor_custom_fields';

        // Auto-focus first input on load and render stored fields
        document.addEventListener('DOMContentLoaded', function() {
            renderStoredFields();
            const firstInput = document.querySelector('#fields-grid input');
            if (firstInput) firstInput.focus();
        });

        function getStoredFields() {
            const stored = localStorage.getItem(STORAGE_KEY);
            return stored ? JSON.parse(stored) : [];
        }

        function storeField(field) {
            const fields = getStoredFields();
            fields.push(field);
            localStorage.setItem(STORAGE_KEY, JSON.stringify(fields));
        }

        function renderStoredFields() {
            const fields = getStoredFields();
            const grid = document.getElementById('fields-grid');
            const standardInputsCount = grid.querySelectorAll('input').length;

            fields.forEach((field, idx) => {
                const label = language === 'ur' ? field.labelUr : field.labelEn;
                const fieldHtml = createFieldHtml(field.name, label, standardInputsCount + idx);
                grid.insertAdjacentHTML('beforeend', fieldHtml);
            });
        }

        function createFieldHtml(name, label, index) {
            return `
                <div class="space-y-3 group animate-fadeIn">
                    <label for="data_${name}" class="block text-base font-bold text-indigo-600 ${language === 'ur' ? 'text-right' : ''}">
                        ${label}
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="data[${name}]" 
                               id="data_${name}"
                               class="block w-full border-2 border-indigo-200 bg-indigo-50/30 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-center font-black text-2xl py-4 transition-all"
                               placeholder="0.0"
                               tabindex="${index + 1}"
                               onkeydown="handleKeydown(event, ${index})">
                    </div>
                </div>
            `;
        }

        function addNewField() {
            let labelEn = '';
            let labelUr = '';

            if (language === 'ur') {
                labelUr = prompt('اردو میں فیلڈ کا نام درج کریں:');
                if (!labelUr) return;
                labelEn = labelUr; // Fallback for data key
            } else {
                labelEn = prompt('Enter field name in English:');
                if (!labelEn) return;
                labelUr = labelEn; // Fallback
            }

            const fieldName = labelEn.toLowerCase().replace(/[^a-z0-9]/g, '_') + '_' + Date.now();
            const label = language === 'ur' ? labelUr : labelEn;
            
            const grid = document.getElementById('fields-grid');
            const inputs = grid.querySelectorAll('input');
            const index = inputs.length;
            
            const fieldHtml = createFieldHtml(fieldName, label, index);
            grid.insertAdjacentHTML('beforeend', fieldHtml);

            // Save to localStorage
            storeField({
                name: fieldName,
                labelEn: labelEn,
                labelUr: labelUr
            });
            
            // Focus the newly added field
            setTimeout(() => {
                document.getElementById(`data_${fieldName}`).focus();
            }, 100);
        }

        // Make Enter key act like Tab for faster entry
        function handleKeydown(event, index) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const inputs = document.querySelectorAll('#fields-grid input');
                if (inputs[index + 1]) {
                    inputs[index + 1].focus();
                } else {
                    document.getElementById('notes').focus();
                }
            }
        }
    </script>
    @endpush

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&display=swap');
        
        [dir="rtl"] {
            font-family: 'Noto Nastaliq Urdu', serif;
        }

        /* Responsive font adjustments for Urdu */
        [dir="rtl"] .font-bold {
            line-height: 2;
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #818cf8;
        }
    </style>
@endsection
