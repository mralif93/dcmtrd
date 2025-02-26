<!-- resources/views/checklists/create-response.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Complete Checklist') }}: {{ $checklist->name }}
            </h2>
            <a href="{{ route('checklists.show', $checklist) }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Checklist
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('checklists.store-response', $checklist) }}" method="POST" class="space-y-6" id="checklistResponseForm">
                        @csrf

                        <!-- Basic Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Response Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit</label>
                                    <select id="unit_id" name="unit_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->property->name }} - {{ $unit->unit_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tenant_id" class="block text-sm font-medium text-gray-700">Tenant (Optional)</label>
                                    <select id="tenant_id" name="tenant_id" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="">None</option>
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                                {{ $tenant->first_name }} {{ $tenant->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tenant_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="completed_by" class="block text-sm font-medium text-gray-700">Completed By</label>
                                    <input type="text" id="completed_by" name="completed_by" value="{{ old('completed_by') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300" required>
                                    @error('completed_by')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300" required>
                                        <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea id="notes" name="notes" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Checklist Items -->
                        @if($checklist->items->isNotEmpty())
                            @foreach($checklist->sections as $section)
                                <div class="border-b pb-6">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">{{ $section }}</h3>
                                    
                                    <div class="space-y-6">
                                        @foreach($checklist->items->where('section', $section) as $item)
                                            <div class="bg-gray-50 p-4 rounded">
                                                <div class="mb-2 flex justify-between">
                                                    <label for="item_{{ $item->id }}" class="block font-medium text-gray-700">
                                                        {{ $item->item_name }}
                                                        @if($item->required)
                                                            <span class="text-red-500">*</span>
                                                        @endif
                                                    </label>
                                                    @if($item->description)
                                                        <span class="text-sm text-gray-500">{{ $item->description }}</span>
                                                    @endif
                                                </div>
                                                
                                                <div class="mt-2">
                                                    @if($item->type === 'Boolean')
                                                        <div class="flex items-center space-x-4">
                                                            <label class="inline-flex items-center">
                                                                <input type="radio" name="response_data[{{ $item->id }}]" value="Yes" 
                                                                    {{ old("response_data.{$item->id}") === 'Yes' ? 'checked' : '' }}
                                                                    class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                    {{ $item->required ? 'required' : '' }}>
                                                                <span class="ml-2">Yes</span>
                                                            </label>
                                                            <label class="inline-flex items-center">
                                                                <input type="radio" name="response_data[{{ $item->id }}]" value="No" 
                                                                    {{ old("response_data.{$item->id}") === 'No' ? 'checked' : '' }}
                                                                    class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                    {{ $item->required ? 'required' : '' }}>
                                                                <span class="ml-2">No</span>
                                                            </label>
                                                            <label class="inline-flex items-center">
                                                                <input type="radio" name="response_data[{{ $item->id }}]" value="N/A" 
                                                                    {{ old("response_data.{$item->id}") === 'N/A' ? 'checked' : '' }}
                                                                    class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                                <span class="ml-2">N/A</span>
                                                            </label>
                                                        </div>
                                                    @elseif($item->type === 'Text')
                                                        <textarea name="response_data[{{ $item->id }}]" rows="2" 
                                                            class="mt-1 block w-full rounded-md border-gray-300"
                                                            {{ $item->required ? 'required' : '' }}>{{ old("response_data.{$item->id}") }}</textarea>
                                                    @elseif($item->type === 'Number')
                                                        <input type="number" name="response_data[{{ $item->id }}]" 
                                                            value="{{ old("response_data.{$item->id}") }}" 
                                                            class="mt-1 block w-full rounded-md border-gray-300"
                                                            {{ $item->required ? 'required' : '' }}>
                                                    @elseif($item->type === 'Rating')
                                                        <div class="flex items-center space-x-4">
                                                            @foreach($item->options as $option)
                                                                <label class="inline-flex items-center">
                                                                    <input type="radio" name="response_data[{{ $item->id }}]" value="{{ $option }}" 
                                                                        {{ old("response_data.{$item->id}") === $option ? 'checked' : '' }}
                                                                        class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                        {{ $item->required ? 'required' : '' }}>
                                                                    <span class="ml-2">{{ $option }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-6">
                                <p class="text-gray-500">No items found in this checklist. Please add items before creating a response.</p>
                                <div class="mt-4">
                                    <a href="{{ route('checklists.edit', $checklist) }}" class="text-blue-600 hover:text-blue-900">
                                        Go to edit checklist
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('checklists.show', $checklist) }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>