<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Site Visit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('site-visits.index') }}" class="text-blue-500 hover:underline">
                            &larr; Back to Site Visits
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="mb-4 bg-red-50 p-4 rounded-md">
                            <div class="text-red-600 font-medium mb-2">
                                There were errors with your submission:
                            </div>
                            <ul class="list-disc pl-5 text-red-600">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('site-visits.update', $siteVisit) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Property Selection -->
                            <div>
                                <label for="property_id" class="block text-sm font-medium text-gray-700 mb-1">Property *</label>
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
                                <label for="date_site_visit" class="block text-sm font-medium text-gray-700 mb-1">Visit Date *</label>
                                <input type="date" name="date_site_visit" id="date_site_visit" 
                                    value="{{ old('date_site_visit', $siteVisit->date_site_visit->format('Y-m-d')) }}" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Inspector Name -->
                            <div>
                                <label for="inspector_name" class="block text-sm font-medium text-gray-700 mb-1">Inspector Name</label>
                                <input type="text" name="inspector_name" id="inspector_name" value="{{ old('inspector_name', $siteVisit->inspector_name) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                <select name="status" id="status" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ old('status', $siteVisit->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes', $siteVisit->notes) }}</textarea>
                            </div>

                            <!-- Attachment -->
                            <div class="md:col-span-2">
                                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attachment</label>
                                
                                @if($siteVisit->attachment)
                                    <div class="mb-2 flex items-center">
                                        <span class="text-sm text-gray-600 mr-2">Current file:</span>
                                        <a href="{{ route('site-visits.download', $siteVisit) }}" class="text-blue-500 hover:underline text-sm">
                                            {{ basename($siteVisit->attachment) }}
                                        </a>
                                    </div>
                                @endif
                                
                                <input type="file" name="attachment" id="attachment"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-sm text-gray-500">
                                    Accepted file types: PDF, DOC, DOCX, JPG, JPEG, PNG (max 10MB). Leave empty to keep current file.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('site-visits.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 mr-2">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Update Site Visit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>