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
                </div>

                <!-- Status Section -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd
                                class="flex items-center justify-between mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $compliance->status == 'Active'
                                        ? 'bg-green-100 text-green-800'
                                        : ($compliance->status == 'Pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($compliance->status == 'Rejected'
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-gray-100 text-gray-800')) }}">
                                    {{ $compliance->status }}
                                </span>

                                <!-- Approval Actions -->
                                @if ($compliance->status == 'Pending')
                                    <div class="flex space-x-2">
                                        <!-- Approve Button -->
                                        <form action="{{ route('compliance-covenant-a.approve', $compliance) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Approve
                                            </button>
                                        </form>

                                        <!-- Reject Button (Modal Trigger) -->
                                        <button type="button" onclick="openRejectModal()"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Reject
                                        </button>
                                    </div>
                                @endif
                            </dd>
                        </div>

                        @if ($compliance->prepared_by)
                            <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $compliance->prepared_by }}</dd>
                            </div>
                        @endif

                        @if ($compliance->verified_by)
                            <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $compliance->verified_by }}</dd>
                            </div>
                        @endif

                        @if ($compliance->approval_datetime)
                            <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ \Carbon\Carbon::parse($compliance->approval_datetime)->format('d/m/Y H:i') }}
                                </dd>
                            </div>
                        @endif

                        @if ($compliance->remarks)
                            <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $compliance->remarks ?? 'N/A' }}</dd>
                            </div>
                        @endif
                    </dl>
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
                                    @if ($compliance->afs_not_required)
                                        <span class="font-bold text-red-600">Not Applicable</span>
                                    @else
                                        {{ $compliance->audited_financial_statements ?? 'Not Submitted' }}
                                    @endif
                                </dd>
                                <dt class="mt-2 text-sm font-medium text-gray-500">Due Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($compliance->afs_not_required)
                                        <span class="font-bold text-red-600">Not Applicable</span>
                                    @else
                                        {{ $compliance->audited_financial_statements_due ?? 'Not Submitted' }}
                                    @endif
                                </dd>
                            </div>

                            <!-- Compliance Certificate -->
                            <div class="p-4 bg-white rounded-lg">
                                <dt class="text-sm font-medium text-gray-500">Compliance Certificate</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($compliance->cc_not_required)
                                        <span class="font-bold text-red-600">Not Applicable</span>
                                    @else
                                        {{ $compliance->compliance_certificate ?? 'Not Submitted' }}
                                    @endif
                                </dd>
                            </div>

                            <!-- Annual Budget -->
                            <div class="p-4 rounded-lg bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Annual Budget</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($compliance->budget_not_required)
                                        <span class="font-bold text-red-600">Not Applicable</span>
                                    @else
                                        {{ $compliance->annual_budget ?? 'Not Submitted' }}
                                    @endif
                                </dd>
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="space-y-4">
                            <!-- Unaudited Financial Statements -->
                            <div class="p-4 bg-white rounded-lg">
                                <dt class="text-sm font-medium text-gray-500">Unaudited Financial Statements</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($compliance->ufs_not_required)
                                        <span class="font-bold text-red-600">Not Applicable</span>
                                    @else
                                        {{ $compliance->unaudited_financial_statements ?? 'Not Submitted' }}
                                    @endif
                                </dd>
                                <dt class="mt-2 text-sm font-medium text-gray-500">Due Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($compliance->ufs_not_required)
                                        <span class="font-bold text-red-600">Not Applicable</span>
                                    @else
                                        {{ $compliance->unaudited_financial_statements_due ?? 'Not Submitted' }}
                                    @endif
                                </dd>
                            </div>

                            <!-- Finance Service Cover Ratio -->
                            <div class="p-4 rounded-lg bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Finance Service Cover Ratio</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($compliance->fscr_not_required)
                                        <span class="font-bold text-red-600">Not Applicable</span>
                                    @else
                                        {{ $compliance->finance_service_cover_ratio ?? 'Not Submitted' }}
                                    @endif
                                </dd>
                            </div>

                            <!-- Computation of Finance to EBITDA -->
                            <div class="p-4 bg-white rounded-lg">
                                <dt class="text-sm font-medium text-gray-500">Computation of Finance to EBITDA</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if ($compliance->ebitda_not_required)
                                        <span class="font-bold text-red-600">Not Applicable</span>
                                    @else
                                        {{ $compliance->computation_of_finance_to_ebitda ?? 'Not Submitted' }}
                                    @endif
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
                        <a href="{{ route('compliance-covenant-a.index') }}"
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

    <!-- Rejection Modal -->
    <div class="fixed inset-0 hidden overflow-y-auto" id="rejectionModal">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal Panel -->
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('compliance-covenant-a.reject', $compliance) }}" method="POST">
                    @csrf
                    <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Reject Compliance Covenant</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Please provide a reason for rejecting this compliance covenant. This information
                                        will be saved in the remarks field.
                                    </p>
                                    <div class="mt-3">
                                        <label for="rejection_reason"
                                            class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                                        <div class="mt-1">
                                            <textarea id="rejection_reason" name="rejection_reason" rows="3"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Reject
                        </button>
                        <button type="button" onclick="closeRejectModal()"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function openRejectModal() {
            document.getElementById('rejectionModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
