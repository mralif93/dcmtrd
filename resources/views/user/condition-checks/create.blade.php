<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Condition Check') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('condition-checks-info.store') }}">
                        @csrf

                        <!-- Checklist ID -->
                        <div class="mb-4">
                            <label for="checklist_id" class="block font-medium text-sm text-gray-700">{{ __('Checklist') }}</label>
                            <select id="checklist_id" name="checklist_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                <option value="">Select Checklist</option>
                                @foreach ($checklists as $checklist)
                                    <option value="{{ $checklist->id }}" {{ old('checklist_id') == $checklist->id ? 'selected' : '' }}>
                                        ID: {{ $checklist->id }} - {{ $checklist->property->name ?? 'No property' }} ({{ $checklist->description ?? 'No description' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('checklist_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Section -->
                        <div class="mb-4">
                            <label for="section" class="block font-medium text-sm text-gray-700">{{ __('Section') }}</label>
                            <select id="section" name="section" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                <option value="">Select Section</option>
                                <option value="External Area" {{ old('section') == 'External Area' ? 'selected' : '' }}>External Area</option>
                                <option value="Internal Area" {{ old('section') == 'Internal Area' ? 'selected' : '' }}>Internal Area</option>
                            </select>
                            @error('section')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Item Number -->
                        <div class="mb-4">
                            <label for="item_number" class="block font-medium text-sm text-gray-700">{{ __('Item Number') }}</label>
                            <input id="item_number" type="text" name="item_number" value="{{ old('item_number') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                            @error('item_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Item Name -->
                        <div class="mb-4">
                            <label for="item_name" class="block font-medium text-sm text-gray-700">{{ __('Item Name') }}</label>
                            <input id="item_name" type="text" name="item_name" value="{{ old('item_name') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                            @error('item_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Satisfied -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input id="is_satisfied" name="is_satisfied" type="checkbox" value="1" {{ old('is_satisfied') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_satisfied" class="ml-2 block text-sm text-gray-900">
                                    {{ __('Condition is Satisfactory') }}
                                </label>
                            </div>
                            @error('is_satisfied')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="mb-4">
                            <label for="remarks" class="block font-medium text-sm text-gray-700">{{ __('Remarks') }}</label>
                            <textarea id="remarks" name="remarks" rows="3" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('condition-checks-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>