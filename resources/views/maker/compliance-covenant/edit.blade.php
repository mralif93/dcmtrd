<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Compliance Covenant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if ($errors->any())
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with
                                your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form action="{{ route('compliance-covenant-m.update', $compliance) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="pb-6 space-y-6">
                        <!-- Basic Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Basic Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer
                                        *</label>
                                    <select name="issuer_id" id="issuer_id" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Issuer --</option>
                                        @foreach ($issuers as $issuer)
                                            <option value="{{ $issuer->id }}" @selected(old('issuer_id', $compliance->issuer_id) == $issuer->id)>
                                                {{ $issuer->issuer_short_name }} - {{ $issuer->issuer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="financial_year_end"
                                        class="block text-sm font-medium text-gray-700">Financial Year End *</label>
                                    <input type="text" name="financial_year_end" id="financial_year_end"
                                        value="{{ old('financial_year_end', $compliance->financial_year_end) }}"
                                        required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="letter_to_issuer" class="block text-sm font-medium text-gray-700">Letter to Issuer *</label>
                                    <input type="date" name="letter_to_issuer" id="letter_to_issuer"
                                        value="{{ old('letter_to_issuer', optional($compliance->letter_to_issuer)->format('Y-m-d')) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <p class="mt-1 text-xs text-gray-500">Enter the date the letter was issued</p>
                                </div>


                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Document Submissions</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="audited_financial_statements"
                                        class="block text-sm font-medium text-gray-700">Audited Financial
                                        Statements</label>
                                    <input type="text" name="audited_financial_statements"
                                        id="audited_financial_statements"
                                        value="{{ old('audited_financial_statements', $compliance->audited_financial_statements) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="audited_financial_statements"
                                        class="block text-sm font-medium text-gray-700">Due Date</label>
                                    <input type="text" name="audited_financial_statements"
                                        id="audited_financial_statements"
                                        value="{{ old('audited_financial_statements', $compliance->audited_financial_statements_due) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="unaudited_financial_statements"
                                        class="block text-sm font-medium text-gray-700">Unaudited Financial
                                        Statements</label>
                                    <input type="text" name="unaudited_financial_statements"
                                        id="unaudited_financial_statements"
                                        value="{{ old('unaudited_financial_statements', $compliance->unaudited_financial_statements) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="unaudited_financial_statements"
                                        class="block text-sm font-medium text-gray-700">Due Date</label>
                                    <input type="text" name="unaudited_financial_statements"
                                        id="unaudited_financial_statements"
                                        value="{{ old('unaudited_financial_statements', $compliance->unaudited_financial_statements_due) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="compliance_certificate"
                                        class="block text-sm font-medium text-gray-700">Compliance Certificate</label>
                                    <input type="text" name="compliance_certificate" id="compliance_certificate"
                                        value="{{ old('compliance_certificate', $compliance->compliance_certificate) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="finance_service_cover_ratio"
                                        class="block text-sm font-medium text-gray-700">Finance Service Cover
                                        Ratio</label>
                                    <input type="text" name="finance_service_cover_ratio"
                                        id="finance_service_cover_ratio"
                                        value="{{ old('finance_service_cover_ratio', $compliance->finance_service_cover_ratio) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="annual_budget" class="block text-sm font-medium text-gray-700">Annual
                                        Budget</label>
                                    <input type="text" name="annual_budget" id="annual_budget"
                                        value="{{ old('annual_budget', $compliance->annual_budget) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                                <div>
                                    <label for="computation_of_finance_to_ebitda"
                                        class="block text-sm font-medium text-gray-700">Computation of Finance to
                                        EBITDA</label>
                                    <input type="text" name="computation_of_finance_to_ebitda"
                                        id="computation_of_finance_to_ebitda"
                                        value="{{ old('computation_of_finance_to_ebitda', $compliance->computation_of_finance_to_ebitda) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-xs text-gray-500">Enter reference number or submission date</p>
                                </div>
                            </div>
                        </div>

                        <!-- System Information -->
                        <div>
                            <h3 class="mb-4 text-lg font-medium text-gray-900">System Information</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $compliance->created_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $compliance->updated_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                @if ($compliance->prepared_by)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $compliance->prepared_by }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($compliance->verified_by)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $compliance->verified_by }}
                                        </dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $compliance->status ?? 'N/A' }}
                                    </dd>
                                </div>
                                @if ($compliance->approval_datetime)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($compliance->approval_datetime)->format('d/m/Y H:i') }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($compliance->remarks)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $compliance->remarks }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('compliance-covenant-m.index') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Compliance Covenant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
