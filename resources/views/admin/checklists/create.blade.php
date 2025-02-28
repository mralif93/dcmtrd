<!-- resources/views/checklists/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Checklist') }}
            </h2>
            <a href="{{ route('checklists.index') }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Checklists
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('checklists.store') }}" method="POST" class="space-y-6" id="checklistForm">
                        @csrf

                        <!-- Basic Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Checklist Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Checklist Type</label>
                                    <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300" required>
                                        <option value="">Select Type</option>
                                        <option value="Move-in" {{ old('type') == 'Move-in' ? 'selected' : '' }}>Move-in</option>
                                        <option value="Move-out" {{ old('type') == 'Move-out' ? 'selected' : '' }}>Move-out</option>
                                        <option value="Inspection" {{ old('type') == 'Inspection' ? 'selected' : '' }}>Inspection</option>
                                        <option value="Maintenance" {{ old('type') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" name="description" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="is_template" class="inline-flex items-center">
                                        <input type="checkbox" id="is_template" name="is_template" value="1" 
                                            {{ old('is_template') ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Is Template</span>
                                    </label>
                                    @error('is_template')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="active" class="inline-flex items-center">
                                        <input type="checkbox" id="active" name="active" value="1" 
                                            {{ old('active', '1') == '1' ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Active</span>
                                    </label>
                                    @error('active')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sections -->
                        <div class="border-b pb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Sections</h3>
                                <button type="button" id="addSection" 
                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo">
                                    Add Section
                                </button>
                            </div>
                            
                            <div id="sections-container" class="space-y-4 mt-4">
                                <div class="flex items-center">
                                    <input type="text" name="sections[]" placeholder="Section name" 
                                        class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <button type="button" class="remove-section ml-2 text-red-600 hover:text-red-900">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            @error('sections')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('checklists.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addSectionButton = document.getElementById('addSection');
            const sectionsContainer = document.getElementById('sections-container');
            
            // Add section
            addSectionButton.addEventListener('click', function() {
                const newSection = document.createElement('div');
                newSection.className = 'flex items-center';
                newSection.innerHTML = `
                    <input type="text" name="sections[]" placeholder="Section name" 
                        class="mt-1 block w-full rounded-md border-gray-300" required>
                    <button type="button" class="remove-section ml-2 text-red-600 hover:text-red-900">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                `;
                sectionsContainer.appendChild(newSection);
            });
            
            // Remove section
            sectionsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-section')) {
                    const section = e.target.closest('.flex');
                    // Don't remove if it's the last section
                    if (sectionsContainer.children.length > 1) {
                        section.remove();
                    }
                }
            });
            
            // Form validation
            document.getElementById('checklistForm').addEventListener('submit', function(e) {
                const sections = document.querySelectorAll('input[name="sections[]"]');
                if (sections.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one section');
                }
            });
        });
    </script>
</x-app-layout>