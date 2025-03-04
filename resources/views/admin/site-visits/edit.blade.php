<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Site Visit') }}
            </h2>
            <a href="{{ route('site-visits.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded shadow-sm transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg transition-all duration-300 hover:shadow-lg">
                <div class="p-4 sm:p-6 bg-white">
                    <!-- Form Header -->
                    <div class="mb-6 pb-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900">Site Visit Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Update the details for this site visit. Fields marked with * are required.</p>
                    </div>

                    <form action="{{ route('site-visits.update', $siteVisit) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Main Form Content -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Property Selection -->
                            <div>
                                <label for="property_id" class="block text-sm font-medium text-gray-700 mb-2">Property *</label>
                                <select name="property_id" id="property_id" required 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Select Property</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}" {{ old('property_id', $siteVisit->property_id) == $property->id ? 'selected' : '' }}>
                                            {{ $property->name }} ({{ $property->address }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Visit Date -->
                            <div>
                                <label for="date_visit" class="block text-sm font-medium text-gray-700 mb-2">Visit Date *</label>
                                <input type="date" name="date_visit" id="date_visit" 
                                    value="{{ old('date_visit', $siteVisit->date_visit->format('Y-m-d')) }}" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Visit Time -->
                            <div>
                                <label for="time_visit" class="block text-sm font-medium text-gray-700 mb-2">Visit Time *</label>
                                <input type="date" name="time_visit" id="time_visit" 
                                    value="{{ old('time_visit', $siteVisit->time_visit->format('h:i A')) }}" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Inspector Name -->
                            <div>
                                <label for="inspector_name" class="block text-sm font-medium text-gray-700 mb-2">Inspector Name</label>
                                <input type="text" name="inspector_name" id="inspector_name" value="{{ old('inspector_name', $siteVisit->inspector_name) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Enter inspector's name">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                                <select name="status" id="status" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ old('status', $siteVisit->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Enter any additional notes or observations">{{ old('notes', $siteVisit->notes) }}</textarea>
                        </div>

                        <!-- Attachment Section -->
                        <div>
                            <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">Attachment</label>
                            
                            @if($siteVisit->attachment)
                                <div class="mb-3 flex items-center p-2 bg-blue-50 rounded-md">
                                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600 mr-2">Current file:</span>
                                    <a href="{{ route('site-visits.download', $siteVisit) }}" class="text-blue-600 hover:underline text-sm font-medium">
                                        {{ basename($siteVisit->attachment) }}
                                    </a>
                                </div>
                            @endif
                            
                            <div class="mt-2">
                                <input type="file" name="attachment" id="attachment"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-2 text-sm text-gray-500">
                                    Accepted file types: PDF, DOC, DOCX, JPG, JPEG, PNG (max 10MB). Leave empty to keep current file.
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-5 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                                <a href="{{ route('site-visits.index') }}" 
                                   class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                    Update Site Visit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>