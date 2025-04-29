<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Legal Documentation') }}
            </h2>
            <a href="{{ route('legal.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                Back
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('checklist-legal-l.update', $checklistLegalDocumentation) }}">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Legal Documentation Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Title Information -->
                                <div>
                                    <label for="title_ref" class="block text-sm font-medium text-gray-500">Title Reference</label>
                                    <input id="title_ref" type="text" name="title_ref" value="{{ old('title_ref', $checklistLegalDocumentation->title_ref) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('title_ref')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="title_location" class="block text-sm font-medium text-gray-500">Title Location</label>
                                    <input id="title_location" type="text" name="title_location" value="{{ old('title_location', $checklistLegalDocumentation->title_location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('title_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Trust Deed Information -->
                                <div>
                                    <label for="trust_deed_ref" class="block text-sm font-medium text-gray-500">Trust Deed Reference</label>
                                    <input id="trust_deed_ref" type="text" name="trust_deed_ref" value="{{ old('trust_deed_ref', $checklistLegalDocumentation->trust_deed_ref) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trust_deed_ref')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="trust_deed_location" class="block text-sm font-medium text-gray-500">Trust Deed Location</label>
                                    <input id="trust_deed_location" type="text" name="trust_deed_location" value="{{ old('trust_deed_location', $checklistLegalDocumentation->trust_deed_location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trust_deed_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Sale and Purchase Agreement -->
                                <div class="col-span-2">
                                    <label for="sale_purchase_agreement" class="block text-sm font-medium text-gray-500">Sale & Purchase Agreement</label>
                                    <input id="sale_purchase_agreement" type="text" name="sale_purchase_agreement" value="{{ old('sale_purchase_agreement', $checklistLegalDocumentation->sale_purchase_agreement) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('sale_purchase_agreement')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Lease Agreement Information -->
                                <div>
                                    <label for="lease_agreement_ref" class="block text-sm font-medium text-gray-500">Lease Agreement Reference</label>
                                    <input id="lease_agreement_ref" type="text" name="lease_agreement_ref" value="{{ old('lease_agreement_ref', $checklistLegalDocumentation->lease_agreement_ref) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('lease_agreement_ref')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="lease_agreement_location" class="block text-sm font-medium text-gray-500">Lease Agreement Location</label>
                                    <input id="lease_agreement_location" type="text" name="lease_agreement_location" value="{{ old('lease_agreement_location', $checklistLegalDocumentation->lease_agreement_location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('lease_agreement_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Agreement to Lease -->
                                <div class="col-span-2">
                                    <label for="agreement_to_lease" class="block text-sm font-medium text-gray-500">Agreement to Lease</label>
                                    <input id="agreement_to_lease" type="text" name="agreement_to_lease" value="{{ old('agreement_to_lease', $checklistLegalDocumentation->agreement_to_lease) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('agreement_to_lease')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Maintenance Agreement Information -->
                                <div>
                                    <label for="maintenance_agreement_ref" class="block text-sm font-medium text-gray-500">Maintenance Agreement Reference</label>
                                    <input id="maintenance_agreement_ref" type="text" name="maintenance_agreement_ref" value="{{ old('maintenance_agreement_ref', $checklistLegalDocumentation->maintenance_agreement_ref) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('maintenance_agreement_ref')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="maintenance_agreement_location" class="block text-sm font-medium text-gray-500">Maintenance Agreement Location</label>
                                    <input id="maintenance_agreement_location" type="text" name="maintenance_agreement_location" value="{{ old('maintenance_agreement_location', $checklistLegalDocumentation->maintenance_agreement_location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('maintenance_agreement_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Development Agreement -->
                                <div class="col-span-2">
                                    <label for="development_agreement" class="block text-sm font-medium text-gray-500">Development Agreement</label>
                                    <input id="development_agreement" type="text" name="development_agreement" value="{{ old('development_agreement', $checklistLegalDocumentation->development_agreement) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('development_agreement')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Other Legal Documents -->
                                <div class="col-span-2">
                                    <label for="other_legal_docs" class="block text-sm font-medium text-gray-500">Other Legal Documents</label>
                                    <textarea id="other_legal_docs" name="other_legal_docs" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('other_legal_docs', $checklistLegalDocumentation->other_legal_docs) }}</textarea>
                                    @error('other_legal_docs')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('legal.dashboard', ['section' => 'reits']) }}" 
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
                                    Update Documentation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>