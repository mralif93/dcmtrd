<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Compliance Covenant Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <!-- Header Section -->
                <div class="flex items-center justify-between px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Compliance Covenant Information</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('compliance-covenant-m.edit', $compliance) }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>

                <!-- Status Banner -->
                <div
                    class="{{ $compliance->isCompliant() ? 'bg-green-50' : 'bg-red-50' }} px-4 py-3 border-t border-b border-gray-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @if ($compliance->isCompliant())
                                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3">
                            <h3
                                class="text-sm font-medium {{ $compliance->isCompliant() ? 'text-green-800' : 'text-red-800' }}">
                                {{ $compliance->isCompliant() ? 'Compliant' : 'Non-Compliant' }}
                            </h3>
                            @if (!$compliance->isCompliant())
                                <div
                                    class="mt-2 text-sm {{ $compliance->isCompliant() ? 'text-green-700' : 'text-red-700' }}">
                                    <p>Missing documents:</p>
                                    <ul class="pl-5 mt-1 list-disc">
                                        @foreach ($compliance->getMissingDocuments() as $document)
                                            <li>{{ $document }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Basic Information Section -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Issuer Short Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $compliance->issuer->issuer_short_name }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Financial Year End</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $compliance->financial_year_end }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Issuer of Letter</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $compliance->letter_to_issuer ? \Carbon\Carbon::parse($compliance->letter_to_issuer)->format('d/m/Y') : '-' }}
                            </dd>                            
                        </div>
                        
                    </dl>
                </div>

                <!-- Documents Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Document Submissions</h3>
                    </div>
                    <div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-2">
                        <!-- Column 1 -->
                        <div class="space-y-4">
                            <!-- Audited Financial Statements -->
                            <div class="p-4 rounded-lg bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Audited Financial Statements</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $compliance->audited_financial_statements ?? 'Not Submitted' }}
                                </dd>
                                <dt class="mt-2 text-sm font-medium text-gray-500">Due Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $compliance->audited_financial_statements_due ?? 'Not Submitted' }}
                                </dd>
                            </div>

                            <!-- Compliance Certificate -->
                            <div class="p-4 bg-white rounded-lg">
                                <dt class="text-sm font-medium text-gray-500">Compliance Certificate</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $compliance->compliance_certificate ?? 'Not Submitted' }}
                                </dd>
                            </div>

                            <!-- Annual Budget -->
                            <div class="p-4 rounded-lg bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Annual Budget</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $compliance->annual_budget ?? 'Not Submitted' }}
                                </dd>
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="space-y-4">
                            <!-- Unaudited Financial Statements -->
                            <div class="p-4 bg-white rounded-lg">
                                <dt class="text-sm font-medium text-gray-500">Unaudited Financial Statements</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $compliance->unaudited_financial_statements ?? 'Not Submitted' }}
                                </dd>
                                <dt class="mt-2 text-sm font-medium text-gray-500">Due Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $compliance->unaudited_financial_statements_due ?? 'Not Submitted' }}
                                </dd>
                            </div>

                            <!-- Finance Service Cover Ratio -->
                            <div class="p-4 rounded-lg bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Finance Service Cover Ratio</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $compliance->finance_service_cover_ratio ?? 'Not Submitted' }}
                                </dd>
                            </div>

                            <!-- Computation of Finance to EBITDA -->
                            <div class="p-4 bg-white rounded-lg">
                                <dt class="text-sm font-medium text-gray-500">Computation of Finance to EBITDA</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $compliance->computation_of_finance_to_ebitda ?? 'Not Submitted' }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">System Information</h3>
                    </div>
                    <dl>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $compliance->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $compliance->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="px-4 py-4 border-t border-gray-200 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('compliance-covenant-m.index') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
