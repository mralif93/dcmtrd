<!-- resources/views/appointments/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Appointment') }}
            </h2>
            <a href="{{ route('appointment-m.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
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

                    <form method="POST" action="{{ route('appointment-m.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Appointment Details</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Date of Approval -->
                                <div>
                                    <label for="date_of_approval" class="block text-sm font-medium text-gray-500">Date of Approval</label>
                                    <input id="date_of_approval" type="date" name="date_of_approval" value="{{ old('date_of_approval') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('date_of_approval')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Portfolio Selection -->
                                <div>
                                    <label for="portfolio_id" class="block text-sm font-medium text-gray-500">Portfolio</label>
                                    <select id="portfolio_id" name="portfolio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select a Portfolio</option>
                                        @foreach($portfolios as $portfolio)
                                            <option value="{{ $portfolio->id }}" {{ old('portfolio_id') == $portfolio->id ? 'selected' : '' }}>
                                                {{ $portfolio->portfolio_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('portfolio_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Party Name -->
                                <div class="col-span-2">
                                    <label for="party_name" class="block text-sm font-medium text-gray-500">Party Name</label>
                                    <input id="party_name" type="text" name="party_name" value="{{ old('party_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('party_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-500">Description</label>
                                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estimated Amount -->
                                <div class="col-span-2">
                                    <label for="estimated_amount" class="block text-sm font-medium text-gray-500">Estimated Amount</label>
                                    <input id="estimated_amount" type="number" step="0.01" name="estimated_amount" value="{{ old('estimated_amount') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('estimated_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Remarks -->
                                <div class="col-span-2">
                                    <label for="remarks" class="block text-sm font-medium text-gray-500">Remarks</label>
                                    <textarea id="remarks" name="remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Attachment -->
                                <div class="col-span-2">
                                    <label for="attachment" class="block text-sm font-medium text-gray-500">Attachment</label>
                                    <input id="attachment" type="file" name="attachment" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-6 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="mt-1 text-sm text-gray-500">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (max 10MB)</p>
                                    @error('attachment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('appointment-m.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Create Appointment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>