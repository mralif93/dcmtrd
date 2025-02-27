<!-- resources/views/site-visits/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Site Visit') }}
            </h2>
            <a href="{{ route('site-visits.show', $siteVisit) }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Site Visit
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
                    <form action="{{ route('site-visits.update', $siteVisit) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Visitor Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="visitor_name" class="block text-sm font-medium text-gray-700">Visitor Name</label>
                                    <input type="text" id="visitor_name" name="visitor_name" value="{{ old('visitor_name', $siteVisit->visitor_name) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('visitor_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="visitor_email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="visitor_email" name="visitor_email" value="{{ old('visitor_email', $siteVisit->visitor_email) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('visitor_email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="visitor_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" id="visitor_phone" name="visitor_phone" value="{{ old('visitor_phone', $siteVisit->visitor_phone) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('visitor_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Visit Details -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Visit Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                                    <select id="property_id" name="property_id" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="">Select Property</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}" {{ old('property_id', $siteVisit->property_id) == $property->id ? 'selected' : '' }}>
                                                {{ $property->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit</label>
                                    <select id="unit_id" name="unit_id" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit_id', $siteVisit->unit_id) == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->unit_number }} ({{ $unit->property->name ?? 'Unknown Property' }})
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
                                            <option value="{{ $tenant->id }}" {{ old('tenant_id', $siteVisit->tenant_id) == $tenant->id ? 'selected' : '' }}>
                                                {{ $tenant->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tenant_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="visit_date" class="block text-sm font-medium text-gray-700">Visit Date & Time</label>
                                    <input type="datetime-local" id="visit_date" name="visit_date" 
                                        value="{{ old('visit_date', $siteVisit->visit_date->format('Y-m-d\TH:i')) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('visit_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="actual_visit_start" class="block text-sm font-medium text-gray-700">Actual Visit Start</label>
                                    <input type="datetime-local" id="actual_visit_start" name="actual_visit_start" 
                                        value="{{ old('actual_visit_start', $siteVisit->actual_visit_start ? $siteVisit->actual_visit_start->format('Y-m-d\TH:i') : '') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('actual_visit_start')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="actual_visit_end" class="block text-sm font-medium text-gray-700">Actual Visit End</label>
                                    <input type="datetime-local" id="actual_visit_end" name="actual_visit_end" 
                                        value="{{ old('actual_visit_end', $siteVisit->actual_visit_end ? $siteVisit->actual_visit_end->format('Y-m-d\TH:i') : '') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('actual_visit_end')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="visit_type" class="block text-sm font-medium text-gray-700">Visit Type</label>
                                    <select id="visit_type" name="visit_type" class="mt-1 block w-full rounded-md border-gray-300">
                                        @foreach($visitTypes as $type)
                                            <option value="{{ $type }}" {{ old('visit_type', $siteVisit->visit_type) == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('visit_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="visit_status" class="block text-sm font-medium text-gray-700">Visit Status</label>
                                    <select id="visit_status" name="visit_status" class="mt-1 block w-full rounded-md border-gray-300">
                                        @foreach($visitStatuses as $status)
                                            <option value="{{ $status }}" {{ old('visit_status', $siteVisit->visit_status) == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('visit_status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="conducted_by" class="block text-sm font-medium text-gray-700">Conducted By</label>
                                    <input type="text" id="conducted_by" name="conducted_by" value="{{ old('conducted_by', $siteVisit->conducted_by) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('conducted_by')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                                    <select id="source" name="source" class="mt-1 block w-full rounded-md border-gray-300">
                                        @foreach($sources as $source)
                                            <option value="{{ $source }}" {{ old('source', $siteVisit->source) == $source ? 'selected' : '' }}>
                                                {{ $source }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('source')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Additional Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="visitor_feedback" class="block text-sm font-medium text-gray-700">Visitor Feedback</label>
                                    <textarea id="visitor_feedback" name="visitor_feedback" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300">{{ old('visitor_feedback', $siteVisit->visitor_feedback) }}</textarea>
                                    @error('visitor_feedback')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="agent_notes" class="block text-sm font-medium text-gray-700">Agent Notes</label>
                                    <textarea id="agent_notes" name="agent_notes" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300">{{ old('agent_notes', $siteVisit->agent_notes) }}</textarea>
                                    @error('agent_notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements (JSON)</label>
                                    <textarea id="requirements" name="requirements" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300 font-mono text-sm">{{ old('requirements', $siteVisit->requirements) }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">Enter as valid JSON (e.g., {"bedrooms": 2, "bathrooms": 1})</p>
                                    @error('requirements')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="quoted_price" class="block text-sm font-medium text-gray-700">Quoted Price</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="quoted_price" name="quoted_price" step="0.01" 
                                            value="{{ old('quoted_price', $siteVisit->quoted_price) }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('quoted_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="interested" class="inline-flex items-center mt-6">
                                        <input type="checkbox" id="interested" name="interested" value="1" 
                                            {{ old('interested', $siteVisit->interested) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Visitor is interested</span>
                                    </label>
                                    @error('interested')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="follow_up_required" class="inline-flex items-center">
                                        <input type="checkbox" id="follow_up_required" name="follow_up_required" value="1" 
                                            {{ old('follow_up_required', $siteVisit->follow_up_required) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Follow up required</span>
                                    </label>
                                    <div class="mt-2">
                                        <label for="follow_up_date" class="block text-sm font-medium text-gray-700">Follow up date</label>
                                        <input type="date" id="follow_up_date" name="follow_up_date" 
                                            value="{{ old('follow_up_date', $siteVisit->follow_up_date ? $siteVisit->follow_up_date->format('Y-m-d') : '') }}" 
                                            class="mt-1 block w-full rounded-md border-gray-300">
                                    </div>
                                    @error('follow_up_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('site-visits.show', $siteVisit) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>