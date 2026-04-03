@extends('layouts.admin')

@section('header', 'Edit Measurement Template')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.measurement-templates.index') }}" 
               class="text-gray-500 hover:text-indigo-600 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Templates
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Template Settings -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="bg-indigo-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-cog text-indigo-600"></i> Template Settings
                    </h3>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('admin.measurement-templates.update', $template) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Template Type
                            </label>
                            <input type="text" 
                                   id="type" 
                                   value="{{ $template->type }}" 
                                   disabled
                                   class="block w-full border-gray-300 bg-gray-100 rounded-md shadow-sm">
                            <p class="mt-1 text-sm text-gray-500">Template type cannot be changed.</p>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Name (English) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   required
                                   value="{{ old('name', $template->name) }}"
                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="name_urdu" class="block text-sm font-medium text-gray-700 mb-2">
                                Name (Urdu)
                            </label>
                            <input type="text" 
                                   name="name_urdu" 
                                   id="name_urdu" 
                                   value="{{ old('name_urdu', $template->name_urdu) }}"
                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-right">
                            @error('name_urdu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       {{ old('is_active', $template->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Inactive templates won't be available for use.</p>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fa-solid fa-save"></i> Update Template
                        </button>
                    </form>
                </div>
            </div>

            <!-- Add New Column -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="bg-indigo-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-plus text-indigo-600"></i> Add New Column
                    </h3>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('admin.measurement-templates.add-column', $template) }}">
                        @csrf

                        <div class="mb-4">
                            <label for="field_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Field Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="field_name" 
                                   id="field_name" 
                                   required
                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                   placeholder="e.g., chest, length, waist">
                            <p class="mt-1 text-sm text-gray-500">Use lowercase, no spaces or special characters.</p>
                            @error('field_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                                Label (English) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="label" 
                                   id="label" 
                                   required
                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                   placeholder="e.g., Chest, Length, Waist">
                            @error('label')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="label_urdu" class="block text-sm font-medium text-gray-700 mb-2">
                                Label (Urdu)
                            </label>
                            <input type="text" 
                                   name="label_urdu" 
                                   id="label_urdu" 
                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-right"
                                   placeholder="e.g., چھاتی، لمبائی، کمر">
                            @error('label_urdu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                                    Unit
                                </label>
                                <select name="unit" id="unit" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="inch">Inch</option>
                                    <option value="cm">Centimeter</option>
                                    <option value="meter">Meter</option>
                                    <option value="feet">Feet</option>
                                </select>
                            </div>

                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                    Sort Order
                                </label>
                                <input type="number" 
                                       name="sort_order" 
                                       id="sort_order" 
                                       value="0"
                                       min="0"
                                       class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_required" 
                                       id="is_required" 
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Required</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       checked
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fa-solid fa-plus"></i> Add Column
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Existing Columns -->
        <div class="mt-8 bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
            <div class="bg-indigo-50 px-6 py-4 border-b border-gray-200">
                <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-list text-indigo-600"></i> Template Columns ({{ $template->columns->count() }})
                </h3>
            </div>

            <div class="p-6">
                @if($template->columns->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-ruler-combined text-4xl mb-4"></i>
                        <p>No columns added yet. Use the form above to add measurement columns.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($template->columns as $column)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-4">
                                            <div>
                                                <span class="font-medium text-gray-900">{{ $column->label }}</span>
                                                @if($column->label_urdu)
                                                    <span class="text-gray-500">({{ $column->label_urdu }})</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                                    {{ $column->field_name }}
                                                </span>
                                                @if($column->unit)
                                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                                        {{ $column->unit }}
                                                    </span>
                                                @endif
                                                @if($column->is_required)
                                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">
                                                        Required
                                                    </span>
                                                @endif
                                                @if(!$column->is_active)
                                                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button onclick="editColumn({{ $column->toJson() }})" 
                                                class="text-indigo-600 hover:text-indigo-900" 
                                                title="Edit">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.measurement-columns.destroy', $column) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this column?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Column Modal -->
    <div id="editColumnModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Column</h3>
                    <form id="editColumnForm" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="edit_label" class="block text-sm font-medium text-gray-700 mb-2">
                                Label (English) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="label" id="edit_label" required
                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="edit_label_urdu" class="block text-sm font-medium text-gray-700 mb-2">
                                Label (Urdu)
                            </label>
                            <input type="text" name="label_urdu" id="edit_label_urdu"
                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-right">
                        </div>

                        <div class="mb-4">
                            <label for="edit_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                Unit
                            </label>
                            <select name="unit" id="edit_unit" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="inch">Inch</option>
                                <option value="cm">Centimeter</option>
                                <option value="meter">Meter</option>
                                <option value="feet">Feet</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="edit_sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Sort Order
                            </label>
                            <input type="number" name="sort_order" id="edit_sort_order" min="0"
                                   class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_required" id="edit_is_required"
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Required</span>
                            </label>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeEditModal()" 
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fa-solid fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function editColumn(column) {
            document.getElementById('editColumnForm').action = `/admin/measurement-columns/${column.id}`;
            document.getElementById('edit_label').value = column.label;
            document.getElementById('edit_label_urdu').value = column.label_urdu || '';
            document.getElementById('edit_unit').value = column.unit || 'inch';
            document.getElementById('edit_sort_order').value = column.sort_order;
            document.getElementById('edit_is_required').checked = column.is_required;
            
            document.getElementById('editColumnModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editColumnModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('editColumnModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
    @endpush
@endsection