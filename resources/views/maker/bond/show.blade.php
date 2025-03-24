<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Security Information') }}
            </h2>
            
            <!-- Back Button -->
            <a href="{{ route('bond-m.details', $bond->issuer) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div x-data="{ openSection: 'bonds' }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4 pb-6">

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <h2 class="text-2xl font-bold">{{ $bond->bond_sukuk_name }} - {{ $bond->sub_name }}</h2>
                <p>Issuer Name: {{ $bond->issuer->issuer_name }}</p>


                <div class="flex justify-end space-x-2">
                    <x-custom-dropdown>
                        <x-slot name="trigger">
                            Create
                        </x-slot>
                        
                        <x-slot name="content">
                            <a href="{{ route('rating-m.create', $bond) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Rating Movement
                            </a>
                            <a href="{{ route('payment-m.create', $bond) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Payment Schedule
                            </a>
                            @if(!$bond->redemption)
                            <a href="{{ route('redemption-m.create', $bond) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Redemption
                            </a>
                            @endif
                            @if($bond->redemption)
                            <a href="{{ route('call-m.create', $bond) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Call Schedule
                            </a>
                            <a href="{{ route('lockout-m.create', $bond) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Lockout Period
                            </a>
                            @endif
                            <a href="{{ route('trading-m.create', $bond) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Trading Activity
                            </a>
                        </x-slot>
                    </x-custom-dropdown>

                    <x-custom-dropdown>
                        <x-slot name="trigger">
                            Upload
                        </x-slot>
                        
                        <x-slot name="content">
                            <a href="{{ route('rating-m.upload-form', $bond) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Rating Movements
                            </a>
                            <a href="{{ route('payment-m.upload-form', $bond) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Payment Schedules
                            </a>
                            <a href="{{ route('trading-m.upload-form', $bond) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Trading Activities
                            </a>
                        </x-slot>
                    </x-custom-dropdown>
                </div>

                <!-- Bond Details Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'bonds' ? null : 'bonds'" 
                            class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Bond + Sukuk Information</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'bonds' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'bonds'" x-collapse class="border-t border-gray-200 p-6 overflow-x-auto">
                        <!-- Security Information Section -->
                        <section class="mb-8">
                            <h3 class="text-2xl font-semibold text-cyan-500 mb-4">Security Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                        <div>{{ $bond->maturity_date ? $bond->maturity_date->format('d-m-Y') : 'N/A' }}</div>
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
                            <h3 class="text-2xl font-semibold text-cyan-500 mb-4">Latest Trading</h3>
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
                                    <div>{{ $bond->last_traded_date ? $bond->last_traded_date->format('d-m-Y') : 'N/A' }}</div>
                                </div>
                            </div>
                        </section>

                        <!-- Ratings Section -->
                        <section class="mb-8">
                            <h3 class="text-2xl font-semibold text-cyan-500 mb-4">Ratings</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2">
                                    <div class="font-medium">Ratings</div>
                                    <div>{{ $bond->rating }}</div>
                                </div>
                                @if($bond->ratingMovements && $bond->ratingMovements->count() > 0)
                                    <!-- Additional rating information could be shown here if needed -->
                                @endif
                            </div>
                        </section>

                        <!-- Coupon Payment Details Section -->
                        <section class="mb-8">
                            <h3 class="text-2xl font-semibold text-cyan-500 mb-4">Coupon Payment Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Coupon Accrual</div>
                                        <div>{{ $bond->coupon_accrual ? $bond->coupon_accrual->format('d-M-Y') : 'N/A' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">First Coupon Payment Date</div>
                                        <div>{{ $bond->first_coupon_payment_date ? $bond->first_coupon_payment_date->format('d-M-Y') : 'N/A' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Last Coupon Payment Date</div>
                                        <div>{{ $bond->last_coupon_payment_date ? $bond->last_coupon_payment_date->format('d-M-Y') : 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Prev Coupon Payment Date</div>
                                        <div>{{ $bond->prev_coupon_payment_date ? $bond->prev_coupon_payment_date->format('d-M-Y') : 'N/A' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Next Coupon Payment Date</div>
                                        <div>{{ $bond->next_coupon_payment_date ? $bond->next_coupon_payment_date->format('d-M-Y') : 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Issuance Section -->
                        <section class="mb-8">
                            <h3 class="text-2xl font-semibold text-cyan-500 mb-4">Issuance</h3>
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
                            <h3 class="text-2xl font-semibold text-cyan-500 mb-4">Additional Info</h3>
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
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Related Documents & Financials</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'document' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'document'" x-collapse class="border-t border-gray-200 overflow-x-auto">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-700 font-semibold">
                                        <th class="py-3 px-4 text-left">Seq</th>
                                        <th class="py-3 px-4 text-left">Document Type</th>
                                        <th class="py-3 px-4 text-left">Document Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($relatedDocuments && $relatedDocuments->count() > 0)
                                        @foreach($relatedDocuments as $index => $document)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                                <td class="py-3 px-4">{{ $document->document_type }}</td>
                                                <td class="py-3 px-4">
                                                    @if($document->file_path)
                                                        <a href="{{ asset('storage/' . $document->file_path) }}" 
                                                        class="text-blue-600 hover:underline" 
                                                        target="_blank">
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
                                            <td colspan="3" class="py-3 px-4 text-center">No related documents found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            
                            <!-- Pagination -->
                            @if($relatedDocuments && $relatedDocuments instanceof \Illuminate\Pagination\LengthAwarePaginator && $relatedDocuments->hasPages())
                                <div class="flex items-center justify-between mt-4">
                                    <div>
                                        <span class="text-sm text-gray-700">
                                            Displaying results {{ $relatedDocuments->firstItem() }} - {{ $relatedDocuments->lastItem() }} (of {{ $relatedDocuments->total() }})
                                        </span>
                                    </div>
                                    <div class="flex space-x-1">
                                        @foreach($relatedDocuments->getUrlRange(1, $relatedDocuments->lastPage()) as $page => $url)
                                            @if($page == $relatedDocuments->currentPage())
                                                <span class="px-3 py-1 bg-gray-400 text-white rounded">{{ $page }}</span>
                                            @else
                                                <a href="{{ $url }}" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded">{{ $page }}</a>
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
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Rating Movements</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'rating' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'rating'" x-collapse class="border-t border-gray-200 overflow-x-auto">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-700 font-semibold">
                                        <th class="py-3 px-4 text-left">Rating Agency</th>
                                        <th class="py-3 px-4 text-left">Effective Date</th>
                                        <th class="py-3 px-4 text-left">Rating Tenure</th>
                                        <th class="py-3 px-4 text-left">Rating</th>
                                        <th class="py-3 px-4 text-left">Rating Action</th>
                                        <th class="py-3 px-4 text-left">Rating Outlook</th>
                                        <th class="py-3 px-4 text-left">Rating Watch</th>
                                        <th class="py-3 px-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($bond->ratingMovements && $bond->ratingMovements->count() > 0)
                                        @foreach($bond->ratingMovements->sortByDesc('effective_date') as $index => $ratingMovement)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                <td class="py-3 px-4">{{ $ratingMovement->rating_agency }}</td>
                                                <td class="py-3 px-4">{{ $ratingMovement->effective_date ? $ratingMovement->effective_date->format('d-M-Y') : '-' }}</td>
                                                <td class="py-3 px-4">{{ $ratingMovement->rating_tenure }}</td>
                                                <td class="py-3 px-4">{{ $ratingMovement->rating ?? '-' }}</td>
                                                <td class="py-3 px-4">{{ $ratingMovement->rating_action ?? '-' }}</td>
                                                <td class="py-3 px-4">{{ $ratingMovement->rating_outlook ?? '-' }}</td>
                                                <td class="py-3 px-4">{{ $ratingMovement->rating_watch ?? 'Not Applicable' }}</td>
                                                <td class="py-3 px-4">
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('rating-m.show', $ratingMovement) }}" class="text-yellow-600 hover:text-yellow-900" title="View">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('rating-m.edit', $ratingMovement) }}" class="text-yellow-600 hover:text-yellow-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="py-3 px-4 text-center">No rating movements found</td>
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
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Payment Schedules</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'payment' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'payment'" x-collapse class="border-t border-gray-200 overflow-x-auto">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-700 font-semibold">
                                        <th class="py-3 px-4 text-left">Seq</th>
                                        <th class="py-3 px-4 text-left">Start Date</th>
                                        <th class="py-3 px-4 text-left">End Date</th>
                                        <th class="py-3 px-4 text-left">Payment Date</th>
                                        <th class="py-3 px-4 text-left">Ex-Date</th>
                                        <th class="py-3 px-4 text-left">Coupon Rate</th>
                                        <th class="py-3 px-4 text-left">Adjustment Date</th>
                                        <th class="py-3 px-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($bond->paymentSchedules && $bond->paymentSchedules->count() > 0)
                                        @foreach($bond->paymentSchedules->sortBy('start_date') as $index => $schedule)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                                <td class="py-3 px-4">{{ $schedule->start_date ? $schedule->start_date->format('d-M-Y') : '-' }}</td>
                                                <td class="py-3 px-4">{{ $schedule->end_date ? $schedule->end_date->format('d-M-Y') : '-' }}</td>
                                                <td class="py-3 px-4">{{ $schedule->payment_date ? $schedule->payment_date->format('d-M-Y') : '-' }}</td>
                                                <td class="py-3 px-4">{{ $schedule->ex_date ? $schedule->ex_date->format('d-M-Y') : '-' }}</td>
                                                <td class="py-3 px-4">{{ $schedule->coupon_rate ? number_format($schedule->coupon_rate, 2) : '-' }}</td>
                                                <td class="py-3 px-4">{{ $schedule->adjustment_date ? $schedule->adjustment_date->format('d-M-Y') : '-' }}</td>
                                                <td class="py-3 px-4">
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('payment-m.show', $schedule) }}" class="text-yellow-600 hover:text-yellow-900" title="View">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('payment-m.edit', $schedule) }}" class="text-yellow-600 hover:text-yellow-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="py-3 px-4 text-center">No payment schedules found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            
                            <!-- Pagination if needed -->
                            @if($bond->paymentSchedules instanceof \Illuminate\Pagination\LengthAwarePaginator && $bond->paymentSchedules->hasPages())
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
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Redemptions</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'redemption' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'redemption'" x-collapse class="border-t border-gray-200 p-6 overflow-x-auto">
                        <!-- Main Redemption Info -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-2xl font-semibold text-gray-700">Redemption</h3>
                                @if($bond->redemption)
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('redemption-m.show', $bond->redemption) }}" class="text-yellow-600 hover:text-yellow-900" title="View">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('redemption-m.edit', $bond->redemption) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </div>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Allow Partial Call</div>
                                        <div>{{ $bond->redemption?->allow_partial_call ? 'Yes' : 'No' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="font-medium">Last Call Date</div>
                                        <div>{{ $bond->redemption?->last_call_date ? $bond->redemption->last_call_date->format('d-M-Y') : '-' }}</div>
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
                            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Call Schedule</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700 font-semibold">
                                            <th class="py-3 px-4 text-left">Start Date</th>
                                            <th class="py-3 px-4 text-left">End Date</th>
                                            <th class="py-3 px-4 text-left">Call Price</th>
                                            <th class="py-3 px-4 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($bond->redemption && $bond->redemption->callSchedules && $bond->redemption->callSchedules->count() > 0)
                                            @foreach($bond->redemption->callSchedules->sortBy('start_date') as $index => $callSchedule)
                                                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                    <td class="py-3 px-4">{{ $callSchedule->start_date ? $callSchedule->start_date->format('d-M-Y') : '-' }}</td>
                                                    <td class="py-3 px-4">{{ $callSchedule->end_date ? $callSchedule->end_date->format('d-M-Y') : '-' }}</td>
                                                    <td class="py-3 px-4">{{ $callSchedule->call_price ? number_format($callSchedule->call_price, 2) : '-' }}</td>
                                                    <td class="py-3 px-4">
                                                        <div class="flex justify-end space-x-2">
                                                            <a href="{{ route('call-m.show', $callSchedule) }}" class="text-yellow-600 hover:text-yellow-900" title="View">
                                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                </svg>
                                                            </a>
                                                            <a href="{{ route('call-m.edit', $callSchedule) }}" class="text-yellow-600 hover:text-yellow-900">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="py-3 px-4 text-center">No data available in table</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Lockout Period Section -->
                        <div class="mb-8">
                            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Lockout Period</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-700 font-semibold">
                                            <th class="py-3 px-4 text-left">Start Date</th>
                                            <th class="py-3 px-4 text-left">End Date</th>
                                            <th class="py-3 px-4 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($bond->redemption && $bond->redemption->lockoutPeriods && $bond->redemption->lockoutPeriods->count() > 0)
                                            @foreach($bond->redemption->lockoutPeriods->sortBy('start_date') as $index => $lockoutPeriod)
                                                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                    <td class="py-3 px-4">{{ $lockoutPeriod->start_date ? $lockoutPeriod->start_date->format('d-M-Y') : '-' }}</td>
                                                    <td class="py-3 px-4">{{ $lockoutPeriod->end_date ? $lockoutPeriod->end_date->format('d-M-Y') : '-' }}</td>
                                                    <td class="py-3 px-4">
                                                        <div class="flex justify-end space-x-2">
                                                            <a href="{{ route('lockout-m.show', $lockoutPeriod) }}" class="text-yellow-600 hover:text-yellow-900" title="View">
                                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                </svg>
                                                            </a>
                                                            <a href="{{ route('lockout-m.edit', $lockoutPeriod) }}" class="text-yellow-600 hover:text-yellow-900">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="py-3 px-4 text-center">No data available in table</td>
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
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Trading Activities</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'trading' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'trading'" x-collapse class="border-t border-gray-200 overflow-x-auto">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-700 font-semibold">
                                        <th class="py-3 px-4 text-left">Trade Date</th>
                                        <th class="py-3 px-4 text-left">Input Time</th>
                                        <th class="py-3 px-4 text-left">Amount (RM'mil)</th>
                                        <th class="py-3 px-4 text-left">Price</th>
                                        <th class="py-3 px-4 text-left">Yield (%)</th>
                                        <th class="py-3 px-4 text-left">Value Date</th>
                                        <th class="py-3 px-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($bond->tradingActivities && $bond->tradingActivities->count() > 0)
                                        @foreach($bond->tradingActivities as $index => $activity)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                                                <td class="py-3 px-4">{{ $activity->trade_date ? $activity->trade_date->format('d-M-Y') : '-' }}</td>
                                                <td class="py-3 px-4">{{ $activity->input_time ? $activity->input_time->format('H:i:s A') : '-' }}</td>
                                                <td class="py-3 px-4">{{ $activity->amount ?? '-' }}</td>
                                                <td class="py-3 px-4">{{ $activity->price ? number_format($activity->price, 2) : '-' }}</td>
                                                <td class="py-3 px-4">{{ $activity->yield ? number_format($activity->yield, 2) : '-' }}</td>
                                                <td class="py-3 px-4">{{ $activity->value_date ? $activity->value_date->format('d-M-Y') : '-' }}</td>
                                                <td class="py-3 px-4">
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('trading-m.show', $activity) }}" class="text-yellow-600 hover:text-yellow-900" title="View">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('trading-m.edit', $activity) }}" class="text-yellow-600 hover:text-yellow-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="py-3 px-4 text-center">No trading activities found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            
                            <!-- Pagination if needed -->
                            @if(isset($tradingActivities) && $tradingActivities instanceof \Illuminate\Pagination\LengthAwarePaginator && $tradingActivities->hasPages())
                                <div class="mt-4">
                                    {{ $tradingActivities->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Charts Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'chart' ? null : 'chart'" 
                            class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Charts</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'chart' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'chart'" x-collapse class="border-t border-gray-200 p-6 overflow-x-auto">
                        <p>Content</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>