<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Security Information') }}
            </h2>

            <!-- Back Button -->
            <a href="{{ route('bond-a.details', $bond) }}"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div x-data="{ openSection: 'null' }">
            <div class="pb-6 mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">

                <h2 class="text-2xl font-bold">{{ $bond->bond_sukuk_name }} - {{ $bond->sub_name }}</h2>
                <p>Issuer Name: {{ $bond->issuer->issuer_name }}</p>

                <!-- Bond Details Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'bonds' ? null : 'bonds'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Bond + Sukuk Information</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'bonds' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'bonds'" x-collapse
                        class="p-6 overflow-x-auto border-t border-gray-200">
                        <!-- Security Information Section -->
                        <section class="mb-8">
                            <h3 class="mb-4 text-2xl font-semibold text-cyan-500">Security Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Principal</div>
                                        <div>{{ $bond->principal }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Islamic Concept</div>
                                        <div>{{ $bond->facilityInformation->islamic_concept ?? 'N/A' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Instrument Code</div>
                                        <div>{{ $bond->instrument_code }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Issue Date</div>
                                        <div>{{ $bond->issue_date ? $bond->issue_date->format('d-m-Y') : 'N/A' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Coupon Rate</div>
                                        <div>{{ number_format($bond->coupon_rate, 4) }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Coupon Frequency</div>
                                        <div>{{ $bond->coupon_frequency }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Issue Tenure (Years)</div>
                                        <div>{{ number_format($bond->issue_tenure_years, 4) }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Sub Category</div>
                                        <div>{{ $bond->sub_category }}</div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">ISIN Code</div>
                                        <div>{{ $bond->isin_code }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Stock Code</div>
                                        <div>{{ $bond->stock_code }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Category</div>
                                        <div>{{ $bond->category }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Maturity Date</div>
                                        <div>{{ $bond->maturity_date ? $bond->maturity_date->format('d-m-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Coupon Type</div>
                                        <div>{{ $bond->coupon_type }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Day Count</div>
                                        <div>{{ $bond->day_count }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Residual Tenure (Years)</div>
                                        <div>{{ number_format($bond->residual_tenure_years, 4) }}</div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Latest Trading Section -->
                        <section class="mb-8">
                            <h3 class="mb-4 text-2xl font-semibold text-cyan-500">Latest Trading</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Last Traded Yield (%)</div>
                                    <div>{{ number_format($bond->last_traded_yield, 2) }}</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Last Traded Price (RM)</div>
                                    <div>{{ number_format($bond->last_traded_price, 2) }}</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Last Traded Amount (RM'mil)</div>
                                    <div>{{ number_format($bond->last_traded_amount, 2) }}</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Last Traded Date</div>
                                    <div>
                                        {{ $bond->last_traded_date ? $bond->last_traded_date->format('d-m-Y') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Ratings Section -->
                        <section class="mb-8">
                            <h3 class="mb-4 text-2xl font-semibold text-cyan-500">Ratings</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Ratings</div>
                                    <div>{{ $bond->rating }}</div>
                                </div>
                                @if ($bond->ratingMovements && $bond->ratingMovements->count() > 0)
                                    <!-- Additional rating information could be shown here if needed -->
                                @endif
                            </div>
                        </section>

                        <!-- Coupon Payment Details Section -->
                        <section class="mb-8">
                            <h3 class="mb-4 text-2xl font-semibold text-cyan-500">Coupon Payment Details</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Coupon Accrual</div>
                                        <div>
                                            {{ $bond->coupon_accrual ? $bond->coupon_accrual->format('d-M-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">First Coupon Payment Date</div>
                                        <div>
                                            {{ $bond->first_coupon_payment_date ? $bond->first_coupon_payment_date->format('d-M-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Last Coupon Payment Date</div>
                                        <div>
                                            {{ $bond->last_coupon_payment_date ? $bond->last_coupon_payment_date->format('d-M-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Prev Coupon Payment Date</div>
                                        <div>
                                            {{ $bond->prev_coupon_payment_date ? $bond->prev_coupon_payment_date->format('d-M-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Next Coupon Payment Date</div>
                                        <div>
                                            {{ $bond->next_coupon_payment_date ? $bond->next_coupon_payment_date->format('d-M-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Issuance Section -->
                        <section class="mb-8">
                            <h3 class="mb-4 text-2xl font-semibold text-cyan-500">Issuance</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Amount Issued (RM'mil)</div>
                                    <div>{{ number_format($bond->amount_issued, 2) }}</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Amount Outstanding (RM'mil)</div>
                                    <div>{{ number_format($bond->amount_outstanding, 2) }}</div>
                                </div>
                            </div>
                        </section>

                        <!-- Additional Info Section -->
                        <section class="mb-8">
                            <h3 class="mb-4 text-2xl font-semibold text-cyan-500">Additional Info</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Lead Arranger</div>
                                    <div>{{ $bond->lead_arranger }}</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Facility Agent</div>
                                    <div>{{ $bond->facility_agent }}</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Facility Code</div>
                                    <div>{{ $bond->facility_code }}</div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Related Document and Financials Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'document' ? null : 'document'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Related Documents & Financials</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'document' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'document'" x-collapse
                        class="overflow-x-auto border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="font-semibold text-gray-700 bg-gray-200">
                                        <th class="px-4 py-3 text-left">Seq</th>
                                        <th class="px-4 py-3 text-left">Document Type</th>
                                        <th class="px-4 py-3 text-left">Document Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($relatedDocuments && $relatedDocuments->count() > 0)
                                        @foreach ($relatedDocuments as $index => $document)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">{{ $document->document_type }}</td>
                                                <td class="px-4 py-3">
                                                    @if ($document->file_path)
                                                        <a href="{{ asset('storage/' . $document->file_path) }}"
                                                            class="text-blue-600 hover:underline" target="_blank">
                                                            {{ $document->document_name }}
                                                        </a>
                                                    @else
                                                        {{ $document->document_name }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="px-4 py-3 text-center">No related documents
                                                found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            @if (
                                $relatedDocuments &&
                                    $relatedDocuments instanceof \Illuminate\Pagination\LengthAwarePaginator &&
                                    $relatedDocuments->hasPages())
                                <div class="flex items-center justify-between mt-4">
                                    <div>
                                        <span class="text-sm text-gray-700">
                                            Displaying results {{ $relatedDocuments->firstItem() }} -
                                            {{ $relatedDocuments->lastItem() }} (of {{ $relatedDocuments->total() }})
                                        </span>
                                    </div>
                                    <div class="flex space-x-1">
                                        @foreach ($relatedDocuments->getUrlRange(1, $relatedDocuments->lastPage()) as $page => $url)
                                            @if ($page == $relatedDocuments->currentPage())
                                                <span
                                                    class="px-3 py-1 text-white bg-gray-400 rounded">{{ $page }}</span>
                                            @else
                                                <a href="{{ $url }}"
                                                    class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">{{ $page }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Rating Movements Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'rating' ? null : 'rating'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Rating Movements</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'rating' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'rating'" x-collapse
                        class="overflow-x-auto border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="font-semibold text-gray-700 bg-gray-200">
                                        <th class="px-4 py-3 text-left">Rating Agency</th>
                                        <th class="px-4 py-3 text-left">Effective Date</th>
                                        <th class="px-4 py-3 text-left">Rating Tenure</th>
                                        <th class="px-4 py-3 text-left">Rating</th>
                                        <th class="px-4 py-3 text-left">Rating Action</th>
                                        <th class="px-4 py-3 text-left">Rating Outlook</th>
                                        <th class="px-4 py-3 text-left">Rating Watch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($bond->ratingMovements && $bond->ratingMovements->count() > 0)
                                        @foreach ($bond->ratingMovements->sortByDesc('effective_date') as $index => $ratingMovement)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                <td class="px-4 py-3">{{ $ratingMovement->rating_agency }}</td>
                                                <td class="px-4 py-3">
                                                    {{ $ratingMovement->effective_date ? $ratingMovement->effective_date->format('d-M-Y') : '-' }}
                                                </td>
                                                <td class="px-4 py-3">{{ $ratingMovement->rating_tenure }}</td>
                                                <td class="px-4 py-3">{{ $ratingMovement->rating ?? '-' }}</td>
                                                <td class="px-4 py-3">{{ $ratingMovement->rating_action ?? '-' }}</td>
                                                <td class="px-4 py-3">{{ $ratingMovement->rating_outlook ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ $ratingMovement->rating_watch ?? 'Not Applicable' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="px-4 py-3 text-center">No rating movements found
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payment Schedules Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'payment' ? null : 'payment'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Payment Schedules</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'payment' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'payment'" x-collapse
                        class="overflow-x-auto border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="font-semibold text-gray-700 bg-gray-200">
                                        <th class="px-4 py-3 text-left">Seq</th>
                                        <th class="px-4 py-3 text-left">Start Date</th>
                                        <th class="px-4 py-3 text-left">End Date</th>
                                        <th class="px-4 py-3 text-left">Payment Date</th>
                                        <th class="px-4 py-3 text-left">Ex-Date</th>
                                        <th class="px-4 py-3 text-left">Coupon Rate</th>
                                        <th class="px-4 py-3 text-left">Adjustment Date</th>
                                        <th class="px-4 py-3 text-center">Reminder Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($bond->paymentSchedules && $bond->paymentSchedules->count() > 0)
                                        @foreach ($bond->paymentSchedules->sortBy('start_date') as $index => $schedule)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">{{ $schedule->start_date ? $schedule->start_date->format('d-M-Y') : '-' }}</td>
                                                <td class="px-4 py-3">{{ $schedule->end_date ? $schedule->end_date->format('d-M-Y') : '-' }}</td>
                                                <td class="px-4 py-3">{{ $schedule->payment_date ? $schedule->payment_date->format('d-M-Y') : '-' }}</td>
                                                <td class="px-4 py-3">{{ $schedule->ex_date ? $schedule->ex_date->format('d-M-Y') : '-' }}</td>
                                                <td class="px-4 py-3">{{ $schedule->coupon_rate ? number_format($schedule->coupon_rate, 2) : '-' }}</td>
                                                <td class="px-4 py-3">{{ $schedule->adjustment_date ? $schedule->adjustment_date->format('d-M-Y') : '-' }}</td>
                                                <td class="px-4 py-3 text-center">{{ $schedule->reminder_total_date ? $schedule->reminder_total_date : 0 }} Days</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="px-4 py-3 text-center">No payment schedules
                                                found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!-- Pagination if needed -->
                            @if (
                                $bond->paymentSchedules instanceof \Illuminate\Pagination\LengthAwarePaginator &&
                                    $bond->paymentSchedules->hasPages())
                                <div class="mt-4">
                                    {{ $bond->paymentSchedules->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Redemption Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'redemption' ? null : 'redemption'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Redemption</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'redemption' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'redemption'" x-collapse
                        class="p-6 overflow-x-auto border-t border-gray-200">
                        <!-- Main Redemption Info -->
                        <div class="mb-8">
                            <h3 class="mb-4 text-2xl font-semibold text-gray-700">Redemption</h3>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Allow Partial Call</div>
                                        <div>{{ $bond->redemption?->allow_partial_call ? 'Yes' : 'No' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Last Call Date</div>
                                        <div>
                                            {{ $bond->redemption?->last_call_date ? $bond->redemption->last_call_date->format('d-M-Y') : '-' }}
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Redeem to Nearest Denomination</div>
                                        <div>{{ $bond->redemption?->redeem_nearest_denomination ? 'Yes' : 'No' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Call Schedule Section -->
                        <div class="mb-8">
                            <h3 class="mb-4 text-2xl font-semibold text-gray-700">Call Schedule</h3>

                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="font-semibold text-gray-700 bg-gray-200">
                                            <th class="px-4 py-3 text-left">Start Date</th>
                                            <th class="px-4 py-3 text-left">End Date</th>
                                            <th class="px-4 py-3 text-left">Call Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($bond->redemption && $bond->redemption->callSchedules && $bond->redemption->callSchedules->count() > 0)
                                            @foreach ($bond->redemption->callSchedules->sortBy('start_date') as $index => $callSchedule)
                                                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                    <td class="px-4 py-3">
                                                        {{ $callSchedule->start_date ? $callSchedule->start_date->format('d-M-Y') : '-' }}
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        {{ $callSchedule->end_date ? $callSchedule->end_date->format('d-M-Y') : '-' }}
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        {{ $callSchedule->call_price ? number_format($callSchedule->call_price, 2) : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="px-4 py-3 text-center">No data available in
                                                    table</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Lockout Period Section -->
                        <div class="mb-8">
                            <h3 class="mb-4 text-2xl font-semibold text-gray-700">Lockout Period</h3>

                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="font-semibold text-gray-700 bg-gray-200">
                                            <th class="px-4 py-3 text-left">Start Date</th>
                                            <th class="px-4 py-3 text-left">End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($bond->redemption && $bond->redemption->lockoutPeriods && $bond->redemption->lockoutPeriods->count() > 0)
                                            @foreach ($bond->redemption->lockoutPeriods->sortBy('start_date') as $index => $lockoutPeriod)
                                                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                    <td class="px-4 py-3">
                                                        {{ $lockoutPeriod->start_date ? $lockoutPeriod->start_date->format('d-M-Y') : '-' }}
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        {{ $lockoutPeriod->end_date ? $lockoutPeriod->end_date->format('d-M-Y') : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="px-4 py-3 text-center">No data available in
                                                    table</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trading Activities Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'trading' ? null : 'trading'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Trading Activities</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'trading' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'trading'" x-collapse
                        class="overflow-x-auto border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="font-semibold text-gray-700 bg-gray-200">
                                        <th class="px-4 py-3 text-left">Trade Date</th>
                                        <th class="px-4 py-3 text-left">Input Time</th>
                                        <th class="px-4 py-3 text-left">Amount (RM'mil)</th>
                                        <th class="px-4 py-3 text-left">Price</th>
                                        <th class="px-4 py-3 text-left">Yield (%)</th>
                                        <th class="px-4 py-3 text-left">Value Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($bond->tradingActivities && $bond->tradingActivities->count() > 0)
                                        @foreach ($bond->tradingActivities as $index => $activity)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                <td class="px-4 py-3">{{ $activity->trade_date ? $activity->trade_date->format('d-M-Y') : '-' }}</td>
                                                <td class="px-4 py-3">{{ $activity->input_time ? $activity->input_time->format('H:i:s A') : '-' }}</td>
                                                <td class="px-4 py-3">{{ $activity->amount ?? '-' }}</td>
                                                <td class="px-4 py-3">{{ $activity->price ? number_format($activity->price, 2) : '-' }}</td>
                                                <td class="px-4 py-3">{{ $activity->yield ? number_format($activity->yield, 2) : '-' }}</td>
                                                <td class="px-4 py-3">{{ $activity->value_date ? $activity->value_date->format('d-M-Y') : '-' }}</td>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="px-4 py-3 text-center">No trading activities
                                                found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!-- Pagination if needed -->
                            @if (isset($tradingActivities) &&
                                    $tradingActivities instanceof \Illuminate\Pagination\LengthAwarePaginator &&
                                    $tradingActivities->hasPages())
                                <div class="mt-4">
                                    {{ $tradingActivities->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
