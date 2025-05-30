<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Site Visit Log') }}
            </h2>
            <a href="{{ route('site-visit-log-m.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Handling -->
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('site-visit-log-m.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-6 pb-6">
                        <!-- Basic Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Property Dropdown -->
                                <div>
                                    <label for="property_id" class="block text-sm font-medium text-gray-700">Property *</label>
                                    <select name="property_id" id="property_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Property --</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}" @selected(old('property_id') == $property->id)>
                                                {{ $property->name }} - {{ $property->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Category -->
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category" id="category"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Category --</option>
                                        <option value="meeting" @selected(old('category') == 'meeting')>Meeting</option>
                                        <option value="inspection" @selected(old('category') == 'inspection')>Inspection</option>
                                        <option value="maintenance" @selected(old('category') == 'maintenance')>Maintenance</option>
                                        <option value="others" @selected(old('category') == 'others')>Others</option>
                                    </select>
                                </div>
                                
                                <!-- Visit Date Components -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Visit Date</label>
                                    <div class="grid grid-cols-3 gap-3 mt-1">
                                        <!-- Day Select -->
                                        <div>
                                            <select name="visit_day" id="visit_day"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="">Day</option>
                                                @for($i = 1; $i <= 31; $i++)
                                                    @php
                                                        $formattedValue = $i < 10 ? '0'.$i : (string)$i;
                                                    @endphp
                                                    <option value="{{ $formattedValue }}" @selected(old('visit_day') == $formattedValue)>
                                                        {{ $formattedValue }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        
                                        <!-- Month Select -->
                                        <div>
                                            <select name="visit_month" id="visit_month"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="">Month</option>
                                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                                                    @php
                                                        $monthValue = $index + 1;
                                                        $formattedValue = $monthValue < 10 ? '0'.$monthValue : (string)$monthValue;
                                                    @endphp
                                                    <option value="{{ $formattedValue }}" @selected(old('visit_month') == $formattedValue)>
                                                        {{ $month }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- Year Select -->
                                        <div>
                                            <select name="visit_year" id="visit_year"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="">Year</option>
                                                @for($i = date('Y'); $i >= date('Y') - 10; $i--)
                                                    <option value="{{ $i }}" @selected(old('visit_year') == $i)>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Purpose -->
                                <div class="md:col-span-2">
                                    <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose of Visit</label>
                                    <textarea name="purpose" id="purpose" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('purpose') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('site-visit-log-m.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Site Visit Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>