<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Property Improvement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('property-improvements-info.store') }}">
                        @csrf

                        <!-- Checklist ID -->
                        <div class="mb-4">
                            <label for="checklist_id" class="block font-medium text-sm text-gray-700">{{ __('Checklist') }}</label>
                            <select id="checklist_id" name="checklist_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                <option value="">Select Checklist</option>
                                @foreach ($checklists as $checklist)
                                    <option value="{{ $checklist->id }}" {{ old('checklist_id') == $checklist->id ? 'selected' : '' }}>
                                        {{ $checklist->property->name }} - {{ $checklist->description ?? 'Checklist #' . $checklist->id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('checklist_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Item Number -->
                        <div class="mb-4">
                            <label for="item_number" class="block font-medium text-sm text-gray-700">{{ __('Item Number') }}</label>
                            <input id="item_number" type="text" name="item_number" value="{{ old('item_number') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                            <p class="mt-1 text-xs text-gray-500">Example: 5.1, 5.2, etc.</p>
                            @error('item_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Improvement Type -->
                        <div class="mb-4">
                            <label for="improvement_type" class="block font-medium text-sm text-gray-700">{{ __('Improvement Type') }}</label>
                            <select id="improvement_type" name="improvement_type" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                <option value="">Select improvement type</option>
                                <option value="Development" {{ old('improvement_type') == 'Development' ? 'selected' : '' }}>Development</option>
                                <option value="Renovation" {{ old('improvement_type') == 'Renovation' ? 'selected' : '' }}>Renovation</option>
                                <option value="Maintenance" {{ old('improvement_type') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Repair" {{ old('improvement_type') == 'Repair' ? 'selected' : '' }}>Repair</option>
                            </select>
                            @error('improvement_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sub Type -->
                        <div class="mb-4">
                            <label for="sub_type" class="block font-medium text-sm text-gray-700">{{ __('Sub Type (Optional)') }}</label>
                            <input id="sub_type" type="text" name="sub_type" value="{{ old('sub_type') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                            @error('sub_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Scope of Work -->
                        <div class="mb-4">
                            <label for="scope_of_work" class="block font-medium text-sm text-gray-700">{{ __('Scope of Work') }}</label>
                            <textarea id="scope_of_work" name="scope_of_work" rows="3" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">{{ old('scope_of_work') }}</textarea>
                            @error('scope_of_work')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Approval Date -->
                        <div class="mb-4">
                            <label for="approval_date" class="block font-medium text-sm text-gray-700">{{ __('Approval Date (Optional)') }}</label>
                            <input id="approval_date" type="date" name="approval_date" value="{{ old('approval_date') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                            @error('approval_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block font-medium text-sm text-gray-700">{{ __('Status') }}</label>
                            <select id="status" name="status" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="not_applicable" {{ old('status') == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('property-improvements-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
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