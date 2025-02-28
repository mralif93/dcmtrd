
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Compliance Covenant') }}
            </h2>
            <a href="{{ route('compliance-covenants.index') }}" class="bg-gray-500 hover:bg-gray-700 rounded-lg text-white font-bold py-2 px-4">
                Back to Compliance Covenant List
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

                    <!-- Create Form -->
                    <form action="{{ route('compliance-covenants.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Issuer Short Name -->
                            <div>
                                <label for="issuer_short_name" class="block text-sm font-medium text-gray-700">
                                    Issuer Short Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="issuer_short_name" id="issuer_short_name" 
                                    value="{{ old('issuer_short_name') }}" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    required>
                            </div>

                            <!-- Financial Year End -->
                            <div>
                                <label for="financial_year_end" class="block text-sm font-medium text-gray-700">
                                    Financial Year End <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="financial_year_end" id="financial_year_end" 
                                    value="{{ old('financial_year_end') }}" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="e.g. 2024" required>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Document Statuses</h3>
                            <p class="mt-1 text-sm text-gray-500">Add document status details below. Leave blank if not applicable.</p>
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Audited Financial Statements -->
                            <div>
                                <label for="audited_financial_statements" class="block text-sm font-medium text-gray-700">
                                    Audited Financial Statements
                                </label>
                                <input type="text" name="audited_financial_statements" id="audited_financial_statements" 
                                    value="{{ old('audited_financial_statements') }}" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="e.g. Received on 2024-03-15">
                            </div>

                            <!-- Unaudited Financial Statements -->
                            <div>
                                <label for="unaudited_financial_statements" class="block text-sm font-medium text-gray-700">
                                    Unaudited Financial Statements
                                </label>
                                <input type="text" name="unaudited_financial_statements" id="unaudited_financial_statements" 
                                    value="{{ old('unaudited_financial_statements') }}" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="e.g. Received on 2024-02-10">
                            </div>

                            <!-- Compliance Certificate -->
                            <div>
                                <label for="compliance_certificate" class="block text-sm font-medium text-gray-700">
                                    Compliance Certificate
                                </label>
                                <input type="text" name="compliance_certificate" id="compliance_certificate" 
                                    value="{{ old('compliance_certificate') }}" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="e.g. Received on 2024-01-20">
                            </div>

                            <!-- Finance Service Cover Ratio -->
                            <div>
                                <label for="finance_service_cover_ratio" class="block text-sm font-medium text-gray-700">
                                    Finance Service Cover Ratio
                                </label>
                                <input type="text" name="finance_service_cover_ratio" id="finance_service_cover_ratio" 
                                    value="{{ old('finance_service_cover_ratio') }}" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="e.g. 2.5 (Compliant)">
                            </div>

                            <!-- Annual Budget -->
                            <div>
                                <label for="annual_budget" class="block text-sm font-medium text-gray-700">
                                    Annual Budget
                                </label>
                                <input type="text" name="annual_budget" id="annual_budget" 
                                    value="{{ old('annual_budget') }}" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="e.g. Received on 2024-01-05">
                            </div>

                            <!-- Computation of Finance to EBITDA -->
                            <div>
                                <label for="computation_of_finance_to_ebitda" class="block text-sm font-medium text-gray-700">
                                    Computation of Finance to EBITDA
                                </label>
                                <input type="text" name="computation_of_finance_to_ebitda" id="computation_of_finance_to_ebitda" 
                                    value="{{ old('computation_of_finance_to_ebitda') }}" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="e.g. 3.2 (Compliant)">
                            </div>

                            <!-- Ratio Information on Use of Proceeds -->
                            <div>
                                <label for="ratio_information_on_use_of_proceeds" class="block text-sm font-medium text-gray-700">
                                    Ratio Information on Use of Proceeds
                                </label>
                                <input type="text" name="ratio_information_on_use_of_proceeds" id="ratio_information_on_use_of_proceeds" 
                                    value="{{ old('ratio_information_on_use_of_proceeds') }}" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="e.g. Received on 2024-02-28">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Compliance Covenant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>