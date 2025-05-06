<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Checklist') }}
            </h2>
            <a href="{{ route('legal.dashboard', ['section' => 'reits']) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
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

                    <form method="POST" action="{{ route('checklist-l.update', $checklist) }}">
                        @csrf
                        @method('PATCH')

                        <!-- 1.0 Legal Documentation -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">1.0 Legal Documentation</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="border-b">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Items</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Validity/Expiry Date</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Location</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.1 Title</td>
                                            <td class="px-4 py-3">
                                                <input id="title_ref" type="text" name="title_ref" value="{{ old('title_ref', $checklist->legalDocumentation->title_ref ?? '') }}" placeholder="Title Reference" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="title_location" type="text" name="title_location" value="{{ old('title_location', $checklist->legalDocumentation->title_location ?? '') }}" placeholder="Title Location" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.2 Trust Deed</td>
                                            <td class="px-4 py-3">
                                                <input id="trust_deed_ref" type="text" name="trust_deed_ref" value="{{ old('trust_deed_ref', $checklist->legalDocumentation->trust_deed_ref ?? '') }}" placeholder="Trust Deed Reference" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="trust_deed_location" type="text" name="trust_deed_location" value="{{ old('trust_deed_location', $checklist->legalDocumentation->trust_deed_location ?? '') }}" placeholder="Trust Deed Location" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.3 Sale and Purchase Agreement</td>
                                            <td class="px-4 py-3" colspan="2">
                                                <input id="sale_purchase_agreement" type="text" name="sale_purchase_agreement" value="{{ old('sale_purchase_agreement', $checklist->legalDocumentation->sale_purchase_agreement ?? '') }}" placeholder="Reference and Details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.4 Lease Agreement</td>
                                            <td class="px-4 py-3">
                                                <input id="lease_agreement_ref" type="text" name="lease_agreement_ref" value="{{ old('lease_agreement_ref', $checklist->legalDocumentation->lease_agreement_ref ?? '') }}" placeholder="Lease Agreement Reference" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="lease_agreement_location" type="text" name="lease_agreement_location" value="{{ old('lease_agreement_location', $checklist->legalDocumentation->lease_agreement_location ?? '') }}" placeholder="Lease Agreement Location" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.5 Agreement to Lease</td>
                                            <td class="px-4 py-3" colspan="2">
                                                <input id="agreement_to_lease" type="text" name="agreement_to_lease" value="{{ old('agreement_to_lease', $checklist->legalDocumentation->agreement_to_lease ?? '') }}" placeholder="Agreement to Lease Details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.6 Maintenance Agreement</td>
                                            <td class="px-4 py-3">
                                                <input id="maintenance_agreement_ref" type="text" name="maintenance_agreement_ref" value="{{ old('maintenance_agreement_ref', $checklist->legalDocumentation->maintenance_agreement_ref ?? '') }}" placeholder="Maintenance Agreement Reference" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="maintenance_agreement_location" type="text" name="maintenance_agreement_location" value="{{ old('maintenance_agreement_location', $checklist->legalDocumentation->maintenance_agreement_location ?? '') }}" placeholder="Maintenance Agreement Location" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.7 Development Agreement</td>
                                            <td class="px-4 py-3" colspan="2">
                                                <input id="development_agreement" type="text" name="development_agreement" value="{{ old('development_agreement', $checklist->legalDocumentation->development_agreement ?? '') }}" placeholder="Development Agreement Details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.8 Others</td>
                                            <td class="px-4 py-3" colspan="2">
                                                <input id="other_legal_docs" type="text" name="other_legal_docs" value="{{ old('other_legal_docs', $checklist->legalDocumentation->other_legal_docs ?? '') }}" placeholder="Other Legal Documents" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                    Update Checklist
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>