<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Bond + Sukuk Information') }}
            </h2>
            <div class="flex items-center gap-2">

                @if ($bond->status === 'Pending' && auth()->user()->email === 'roslimsyah@artrustees.com.my')
                    <form action="{{ route('bonds.approve', $bond->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('bonds.reject', $bond->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                            Re-Check
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex items-center gap-2 mb-2">
                <span
                    class="px-2 py-1 text-xs font-medium text-white rounded shadow-sm
                    {{ $bond->status == 'Approved' ? 'bg-green-600' : ($bond->status == 'Rejected' ? 'bg-red-600' : 'bg-blue-600') }}">
                    {{ $bond->status ?? 'Unknown' }}
                </span>
            </div>

            <!-- Tab Navigation -->
            <div x-data="{ tab: 'security' }" class="bg-white shadow sm:rounded-lg">
                <div class="border-b">
                    <nav class="flex px-6 py-4 space-x-4">
                        <button @click="tab = 'security'"
                            :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'security' }"
                            class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-600">
                            Bond + Sukuk Information
                        </button>
                        <button @click="tab = 'related'"
                            :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'related' }"
                            class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-600">
                            Related Documents And Financials
                        </button>
                        <button @click="tab = 'rating'"
                            :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'rating' }"
                            class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-600">
                            Ratings Movements
                        </button>
                        <button @click="tab = 'payment_schedule'"
                            :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'payment_schedule' }"
                            class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-600">
                            Payment Schedules
                        </button>
                        <button @click="tab = 'redemption'"
                            :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'redemption' }"
                            class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-600">
                            Redemption
                        </button>
                        <button @click="tab = 'trading'"
                            :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'trading' }"
                            class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-600">
                            Trading Activities
                        </button>
                    </nav>
                </div>

                <!-- Security Information -->
                <div x-show="tab === 'security'" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Security Information</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Principal</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->principal ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Corporate</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->corporate ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ISIN Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->isin_code ?? 'MYBPJ2400312' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Islamic Concept</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bond->islamic_concept ?? 'MURABAHAH, AL-WAKALAH' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Stock Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->stock_code ?? 'PJ240031' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Instrument Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->instrument_code ?? 'IBONDS' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->category ?? 'Corporate' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Issue Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->issue_date ?? '14-11-2024' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Maturity Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->maturity_date ?? '14-11-2030' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coupon Rate</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->coupon_rate ?? '4.2300' }}%</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coupon Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->coupon_type ?? 'Fixed Rate' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coupon Frequency</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->coupon_frequency ?? 'Semi-annually' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Day Count</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->day_count ?? 'ACTUAL/365' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Issue Tenure (Years)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->issue_tenure ?? '6.0027' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Residual Tenure (Years)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->residual_tenure ?? '5.6849' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Sub Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bond->sub_category ?? 'Non SRI and ASEAN Bond' }}</dd>
                        </div>
                    </div>

                    <!-- Coupon Payment Details -->
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Coupon Payment Details</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coupon Accrual</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->coupon_accrual ?? '14-Nov-2024' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Prev Coupon Payment Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->prev_coupon_payment ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">First Coupon Payment Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->first_coupon_payment ?? '14-May-2025' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Next Coupon Payment Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->next_coupon_payment ?? '14-May-2025' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Coupon Payment Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->last_coupon_payment ?? '14-Nov-2030' }}
                            </dd>
                        </div>
                    </div>

                    <!-- Latest Trading Details -->
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Latest Trading Details</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Traded Yield (%)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->last_traded_yield ?? '4.03' }}%</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Traded Price (RM)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->last_traded_price ?? '101.03' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Traded Amount (RM'mil)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->last_traded_amount ?? '3.33' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Traded Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->last_traded_date ?? '05-02-2025' }}</dd>
                        </div>
                    </div>

                    <!-- Rating -->
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Rating</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Rating</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->rating ?? 'N/A' }}</dd>
                        </div>
                    </div>

                    <!-- Issuance -->
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Issuance</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Amount Issued (RM'mil)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->amount_issued ?? '250' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Amount Outstanding (RM'mil)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->amount_outstanding ?? '250' }}</dd>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Additional Info</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lead Arranger</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->lead_arranger ?? 'HLINV' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Agent</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->facility_agent ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->facility_code ?? '202000004' }}</dd>
                        </div>
                    </div>

                </div>

                <!-- Related Documents And Financials -->
                <div x-show="tab === 'related'" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Related Documents And Financials</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Seq</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Document
                                        Type</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Document
                                        Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @forelse($bond->related_documents as $index => $document)
                                    <tr class="border-b">
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $document->type ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $document->name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-sm text-center text-gray-500">No
                                            related documents available</td>
                                    </tr>
                                @endforelse --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Rating Information -->
                <div x-show="tab === 'rating'" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Ratings Information</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Rating
                                        Agency</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Effective
                                        Date</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Rating
                                        Tenure</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Rating
                                    </th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Rating
                                        Action</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Rating
                                        Outlook</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Rating
                                        Watch</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bond->ratingMovements as $rating)
                                    <tr class="border-b">
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $rating->rating_agency ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ $rating->effective_date ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $rating->rating_tenure ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $rating->rating ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $rating->rating_action ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $rating->rating_outlook ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $rating->rating_watch ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-sm text-center text-gray-500">No
                                            rating information available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Payment Schedule -->
                <div x-show="tab === 'payment_schedule'" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Payment Schedule</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Seq</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Start Date
                                    </th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">End Date
                                    </th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Payment
                                        Date</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Ex-Date
                                    </th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Coupon
                                        Rate</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Adjustment
                                        Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bond->paymentSchedules as $index => $payment)
                                    <tr class="border-b">
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ $payment->start_date ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $payment->end_date ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ $payment->payment_date ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $payment->ex_date ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ $payment->coupon_rate ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ $payment->adjustment_date ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-sm text-center text-gray-500">No
                                            payment schedule available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="tab === 'redemption'" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Redemption</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Allow Partial Call</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->redemption->allow_partial_call ?? 'No' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Call Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $bond->redemption->last_call_date ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Redeem to Nearest Denomination</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bond->redemption->redeem_nearest_denomination ?? 'No' }}</dd>
                        </div>
                    </div>

                    <h3 class="mt-6 text-lg font-medium text-gray-900">Call Schedule</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">Start Date</th>
                                    <th class="px-4 py-2 border">End Date</th>
                                    <th class="px-4 py-2 border">Call Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bond->redemption->callSchedules ?? [] as $schedule)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $schedule->start_date ?? '-' }}</td>
                                            <td class="px-4 py-2 border">{{ $schedule->end_date ?? '-' }}</td>
                                            <td class="px-4 py-2 border">{{ $schedule->call_price ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-2 text-center border">No data available
                                            </td>
                                        </tr>
                                    @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h3 class="mt-6 text-lg font-medium text-gray-900">Lockout Period</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">Start Date</th>
                                    <th class="px-4 py-2 border">End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bond->redemption->lockoutPeriods ?? [] as $lockout)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $lockout->start_date ?? '-' }}</td>
                                            <td class="px-4 py-2 border">{{ $lockout->end_date ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-2 text-center border">No data available
                                            </td>
                                        </tr>
                                    @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Trading Activities -->
                <div x-show="tab === 'trading'" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Trading Activities</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Trade Date
                                    </th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Input Time
                                    </th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Amount
                                        (RM'mil)</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Price</th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Yield (%)
                                    </th>
                                    <th class="px-4 py-2 text-sm font-medium text-left text-gray-600 border">Value Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bond->tradingActivities ?? [] as $trade)
                                    <tr class="border-b">
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $trade->trade_date ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $trade->input_time ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $trade->amount ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $trade->price ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $trade->yield ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $trade->value_date ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-sm text-center text-gray-500">
                                            No trading data available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
