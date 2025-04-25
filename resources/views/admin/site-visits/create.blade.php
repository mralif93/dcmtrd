<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Site Visit') }}
            </h2>
            <a href="{{ route('admin.site-visits.index') }}" class="bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white font-bold py-2 px-4">
                &larr; Back to List
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
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.site-visits.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Property Selection -->
                            <div>
                                <label for="property_id" class="block text-sm font-medium text-gray-700 mb-1">Property *</label>
                                <select name="property_id" id="property_id" required 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Select Property</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                            {{ $property->name }} ({{ $property->address }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Visit Date -->
                            <div>
                                <label for="date_visit" class="block text-sm font-medium text-gray-700 mb-1">Visit Date *</label>
                                <input type="date" name="date_visit" id="date_visit" value="{{ old('date_visit') }}" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Visit Time -->
                            <div>
                                <label for="time_visit" class="block text-sm font-medium text-gray-700 mb-1">Visit Time *</label>
                                <input type="time" name="time_visit" id="time_visit" value="{{ old('time_visit') }}" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                <select name="status" id="status" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ old('status', 'scheduled') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Trustee -->
                            <div>
                                <label for="trustee" class="block text-sm font-medium text-gray-700 mb-1">Trustee</label>
                                <input type="text" name="trustee" id="trustee" value="{{ old('trustee') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Manager -->
                            <div>
                                <label for="manager" class="block text-sm font-medium text-gray-700 mb-1">Manager</label>
                                <input type="text" name="manager" id="manager" value="{{ old('manager') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Maintenance Manager -->
                            <div>
                                <label for="maintenance_manager" class="block text-sm font-medium text-gray-700 mb-1">Maintenance Manager</label>
                                <input type="text" name="maintenance_manager" id="maintenance_manager" value="{{ old('maintenance_manager') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Building Manager -->
                            <div>
                                <label for="building_manager" class="block text-sm font-medium text-gray-700 mb-1">Building Manager</label>
                                <input type="text" name="building_manager" id="building_manager" value="{{ old('building_manager') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Prepared By -->
                            <div>
                                <label for="prepared_by" class="block text-sm font-medium text-gray-700 mb-1">Prepared By</label>
                                <input type="text" name="prepared_by" id="prepared_by" value="{{ old('prepared_by') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Verified By -->
                            <div>
                                <label for="verified_by" class="block text-sm font-medium text-gray-700 mb-1">Verified By</label>
                                <input type="text" name="verified_by" id="verified_by" value="{{ old('verified_by') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Attachment -->
                            <div class="md:col-span-2">
                                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attachment</label>
                                <input type="file" name="attachment" id="attachment"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-sm text-gray-500">
                                    Accepted file types: PDF, DOC, DOCX, JPG, JPEG, PNG (max 10MB)
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 border-t border-gray-200 mt-6 pt-6">
                            <a href="{{ route('admin.site-visits.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Site Visit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>