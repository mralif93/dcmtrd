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
                    <div class="mb-4">
                        <a href="{{ route('property-improvements.index') }}" class="text-blue-600 hover:text-blue-900">
                            &larr; Back to Improvements
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p class="font-bold">Please fix the following errors:</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('property-improvements.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="checklist_id" class="block text-sm font-medium text-gray-700">Checklist</label>
                            <select id="checklist_id" name="checklist_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Select a checklist</option>
                                @foreach ($checklists as $checklist)
                                    <option value="{{ $checklist->id }}" {{ old('checklist_id') == $checklist->id ? 'selected' : '' }}>
                                        {{ $checklist->property->name }} - {{ $checklist->description ?? 'Checklist #' . $checklist->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="item_number" class="block text-sm font-medium text-gray-700">Item Number</label>
                            <input type="text" name="item_number" id="item_number" value="{{ old('item_number') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            <p class="mt-1 text-xs text-gray-500">Example: 5.1, 5.2, etc.</p>
                        </div>

                        <div class="mb-4">
                            <label for="improvement_type" class="block text-sm font-medium text-gray-700">Improvement Type</label>
                            <select id="improvement_type" name="improvement_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Select improvement type</option>
                                <option value="Development" {{ old('improvement_type') == 'Development' ? 'selected' : '' }}>Development</option>
                                <option value="Renovation" {{ old('improvement_type') == 'Renovation' ? 'selected' : '' }}>Renovation</option>
                                <option value="Maintenance" {{ old('improvement_type') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Repair" {{ old('improvement_type') == 'Repair' ? 'selected' : '' }}>Repair</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="sub_type" class="block text-sm font-medium text-gray-700">Sub Type (Optional)</label>
                            <input type="text" name="sub_type" id="sub_type" value="{{ old('sub_type') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="scope_of_work" class="block text-sm font-medium text-gray-700">Scope of Work</label>
                            <textarea name="scope_of_work" id="scope_of_work" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('scope_of_work') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="approval_date" class="block text-sm font-medium text-gray-700">Approval Date (Optional)</label>
                            <input type="date" name="approval_date" id="approval_date" value="{{ old('approval_date') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="not_applicable" {{ old('status') == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Improvement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>