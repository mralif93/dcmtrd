<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Compliance Covenant') }}
        </h2>
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
                <form action="{{ route('compliance-covenant-m.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-6 pb-6">
                        <!-- Basic Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                                    <select name="issuer_id" id="issuer_id" required 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Issuer --</option>
                                        @foreach($issuers as $issuer)
                                            <option value="{{ $issuer->id }}" @selected(old('issuer_id') == $issuer->id)>
                                            {{ $issuer->issuer_short_name }} - {{ $issuer->issuer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="financial_year_end" class="block text-sm font-medium text-gray-700">Financial Year End *</label>
                                    <input type="text" name="financial_year_end" id="financial_year_end" 
                                        value="{{ old('financial_year_end') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Documents Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Document Submissions</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="audited_financial_statements" class="block text-sm font-medium text-gray-700">Audited Financial Statements</label>
                                    <input type="text" name="audited_financial_statements" id="audited_financial_statements" 
                                        value="{{ old('audited_financial_statements') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="unaudited_financial_statements" class="block text-sm font-medium text-gray-700">Unaudited Financial Statements</label>
                                    <input type="text" name="unaudited_financial_statements" id="unaudited_financial_statements" 
                                        value="{{ old('unaudited_financial_statements') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="compliance_certificate" class="block text-sm font-medium text-gray-700">Compliance Certificate</label>
                                    <input type="text" name="compliance_certificate" id="compliance_certificate" 
                                        value="{{ old('compliance_certificate') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="finance_service_cover_ratio" class="block text-sm font-medium text-gray-700">Finance Service Cover Ratio</label>
                                    <input type="text" name="finance_service_cover_ratio" id="finance_service_cover_ratio" 
                                        value="{{ old('finance_service_cover_ratio') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="annual_budget" class="block text-sm font-medium text-gray-700">Annual Budget</label>
                                    <input type="text" name="annual_budget" id="annual_budget" 
                                        value="{{ old('annual_budget') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="computation_of_finance_to_ebitda" class="block text-sm font-medium text-gray-700">Computation of Finance to EBITDA</label>
                                    <input type="text" name="computation_of_finance_to_ebitda" id="computation_of_finance_to_ebitda" 
                                        value="{{ old('computation_of_finance_to_ebitda') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="ratio_information_on_use_of_proceeds" class="block text-sm font-medium text-gray-700">Ratio Information on Use of Proceeds</label>
                                    <input type="text" name="ratio_information_on_use_of_proceeds" id="ratio_information_on_use_of_proceeds" 
                                        value="{{ old('ratio_information_on_use_of_proceeds') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Compliance Covenant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>