<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Legal Documentation') }}
            </h2>
            <a href="{{ route('checklist-m.show', $legalDocumentation->checklist->siteVisit->property) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
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

                    <form method="POST" action="{{ route('checklist-legal-documentation-m.update', $legalDocumentation) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="checklist_id" value="{{ $legalDocumentation->checklist->id }}">

                        <!-- Legal Documentation Section -->
                        <div class="mb-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-50 pb-4">Legal Documentation</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Title References -->
                                <div>
                                    <label for="title_ref" class="block text-sm font-medium text-gray-700">Title Reference</label>
                                    <input type="text" name="title_ref" id="title_ref" value="{{ old('title_ref', $legalDocumentation->title_ref) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="title_location" class="block text-sm font-medium text-gray-700">Title Location</label>
                                    <input type="text" name="title_location" id="title_location" value="{{ old('title_location', $legalDocumentation->title_location) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Trust Deed -->
                                <div>
                                    <label for="trust_deed_ref" class="block text-sm font-medium text-gray-700">Trust Deed Reference</label>
                                    <input type="text" name="trust_deed_ref" id="trust_deed_ref" value="{{ old('trust_deed_ref', $legalDocumentation->trust_deed_ref) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="trust_deed_location" class="block text-sm font-medium text-gray-700">Trust Deed Location</label>
                                    <input type="text" name="trust_deed_location" id="trust_deed_location" value="{{ old('trust_deed_location', $legalDocumentation->trust_deed_location) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Sale Purchase Agreement -->
                                <div>
                                    <label for="sale_purchase_agreement" class="block text-sm font-medium text-gray-700">Sale Purchase Agreement</label>
                                    <input type="text" name="sale_purchase_agreement" id="sale_purchase_agreement" value="{{ old('sale_purchase_agreement', $legalDocumentation->sale_purchase_agreement) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Lease Agreement -->
                                <div>
                                    <label for="lease_agreement_ref" class="block text-sm font-medium text-gray-700">Lease Agreement Reference</label>
                                    <input type="text" name="lease_agreement_ref" id="lease_agreement_ref" value="{{ old('lease_agreement_ref', $legalDocumentation->lease_agreement_ref) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="lease_agreement_location" class="block text-sm font-medium text-gray-700">Lease Agreement Location</label>
                                    <input type="text" name="lease_agreement_location" id="lease_agreement_location" value="{{ old('lease_agreement_location', $legalDocumentation->lease_agreement_location) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="agreement_to_lease" class="block text-sm font-medium text-gray-700">Agreement to Lease</label>
                                    <input type="text" name="agreement_to_lease" id="agreement_to_lease" value="{{ old('agreement_to_lease', $legalDocumentation->agreement_to_lease) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Maintenance Agreement -->
                                <div>
                                    <label for="maintenance_agreement_ref" class="block text-sm font-medium text-gray-700">Maintenance Agreement Reference</label>
                                    <input type="text" name="maintenance_agreement_ref" id="maintenance_agreement_ref" value="{{ old('maintenance_agreement_ref', $legalDocumentation->maintenance_agreement_ref) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="maintenance_agreement_location" class="block text-sm font-medium text-gray-700">Maintenance Agreement Location</label>
                                    <input type="text" name="maintenance_agreement_location" id="maintenance_agreement_location" value="{{ old('maintenance_agreement_location', $legalDocumentation->maintenance_agreement_location) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Development Agreement -->
                                <div>
                                    <label for="development_agreement" class="block text-sm font-medium text-gray-700">Development Agreement</label>
                                    <input type="text" name="development_agreement" id="development_agreement" value="{{ old('development_agreement', $legalDocumentation->development_agreement) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Other Legal Docs -->
                                <div class="md:col-span-2">
                                    <label for="other_legal_docs" class="block text-sm font-medium text-gray-700">Other Legal Documents</label>
                                    <textarea name="other_legal_docs" id="other_legal_docs" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('other_legal_docs', $legalDocumentation->other_legal_docs) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('checklist-m.show', $legalDocumentation->checklist->siteVisit->property) }}" 
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
                                    Update Legal Documentation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>