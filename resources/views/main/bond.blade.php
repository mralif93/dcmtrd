<x-main-layout>
	<x-slot name="header">
		<h2 class="text-xl font-semibold leading-tight text-gray-800">
			{{ __('Security Information') }}
		</h2>
	</x-slot>

	<div class="py-8">
		<div class="mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">
			<h1 class="text-xl font-bold">{{ $bond->bond_sukuk_name }} - {{ $bond->sub_name }}</h1>
			<p class="text-grey-800 leading-light">Issuer Name: {{ $bond->issuer->issuer_name }}</p>
		</div>
	</div>

	<div x-data="{ openSection: null }">
		<div class="pb-6 mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">
			<!-- Bond + Sukuk Information -->
			<div class="bg-white shadow-sm sm:rounded-lg">
					<button @click="openSection = openSection === 'bonds' ? null : 'bonds'" 
						class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
						<div class="flex items-center justify-between">
							<h3 class="text-xl font-semibold">Bond + Sukuk Information</h3>
							<svg class="w-6 h-6 transition-transform transform" 
								:class="{ 'rotate-180': openSection === 'bonds' }" 
								fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
							</svg>
						</div>
					</button>
					<div x-show="openSection === 'bonds'" x-collapse class="border-t border-gray-200">
						<div class="p-6 space-y-6 divide-y divide-gray-200">
							<!-- 1. Security Information -->
							<div class="pb-6">
									<h4 class="mb-4 text-lg font-semibold">Security Information</h4>
									<div class="grid grid-cols-2 gap-4">
											<div>
													<p class="text-sm text-gray-500">Principal</p>
													<p class="font-medium">
														{{ optional($bond)->category ?? 'N/A' }}
													</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">ISIN Code</p>
													<p class="font-medium">{{ optional($bond)->isin_code ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Islamic Concept</p>
													<p class="font-medium">{{ optional($bond)->principal ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Stock Code</p>
													<p class="font-medium">{{ optional($bond)->stock_code ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Instrument Code</p>
													<p class="font-medium">{{ optional($bond)->instrument_code ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Category</p>
													<p class="font-medium">{{ optional($bond)->category ?? 'N/A' }}</p>
											</div>
											
											<div>
													<p class="text-sm text-gray-500">Issue Date</p>
													<p class="font-medium">{{ $bond?->issue_date?->format('d/m/Y') ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Maturity Date</p>
													<p class="font-medium">{{ optional($bond)->maturity_date ? optional($bond)->maturity_date->format('d/m/Y') : 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Coupon Rate</p>
													<p class="font-medium">{{ optional($bond)->coupon_rate?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Coupon Type</p>
													<p class="font-medium">{{ optional($bond)->coupon_type ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Coupon Frequency</p>
													<p class="font-medium">{{ optional($bond)->coupon_frequency ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Day Count</p>
													<p class="font-medium">{{ optional($bond)->day_count ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Issue Tenure (Years)</p>
													<p class="font-medium">{{ optional($bond)->issue_tenure_years ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Residual Tenure (Years)</p>
													<p class="font-medium">{{ optional($bond)->residual_tenure_years ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Sub Category</p>
													<p class="font-medium">{{ optional($bond)->sub_category ?? 'N/A' }}</p>
											</div>
									</div>
							</div>

							<!-- 2. Coupon Payment Details -->
							<div class="pt-6 pb-6">
								<h4 class="mb-4 text-lg font-semibold">Coupon Payment Details</h4>
								<div class="grid grid-cols-2 gap-4">
									<div>
										<p class="text-sm text-gray-500">Coupon Accrual</p>
										<p class="font-medium">{{ optional($bond)->coupon_accrual ?? 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">Prev Coupon Payment Date</p>
										<p class="font-medium">{{ optional($bond)->prev_coupon_payment_date ? optional($bond)->prev_coupon_payment_date->format('d-M-Y') : 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">First Coupon Payment Date</p>
										<p class="font-medium">{{ optional($bond)->first_coupon_payment_date ? optional($bond)->first_coupon_payment_date->format('d-M-Y') : 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">Next Coupon Payment Date</p>
										<p class="font-medium">{{ optional($bond)->next_coupon_payment_date ? optional($bond)->next_coupon_payment_date->format('d-M-Y') : 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">Last Coupon Payment Date</p>
										<p class="font-medium">{{ optional($bond)->last_coupon_payment_date ? optional($bond)->last_coupon_payment_date->format('d-M-Y') : 'N/A' }}</p>
									</div>
								</div>
							</div>

							<!-- 3. Latest Trading -->
							<div class="pt-6 pb-6">
									<h4 class="mb-4 text-lg font-semibold">Latest Trading</h4>
									<div class="grid grid-cols-2 gap-4">
											<div>
													<p class="text-sm text-gray-500">Last Traded Yield (%)</p>
													<p class="font-medium">
															{{ $bond->last_traded_yield ?? 'N/A' }}
													</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Last Traded Price (RM)</p>
													<p class="font-medium">
															{{ $bond->last_traded_price ?? 'N/A' }}
													</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Last Traded Amount (RM'mil)</p>
													<p class="font-medium">
															{{ $bond->last_traded_amount ?? 'N/A' }}
													</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Last Traded Date</p>
													<p class="font-medium">
															{{ $bond->last_traded_date->format('d-m-Y') ?? 'N/A' }}
													</p>
											</div>
									</div>
							</div>

							<!-- 4. Ratings -->
							<div class="pt-6 pb-6">
									<h4 class="mb-4 text-lg font-semibold">Ratings</h4>
									<div class="space-y-2">
										{{ $bond->rating ?? 'N/A' }}
									</div>
							</div>

							<!-- 5. Issuance -->
							<div class="pt-6 pb-6">
									<h4 class="mb-4 text-lg font-semibold">Issuance</h4>
									<div class="grid grid-cols-2 gap-4">
											<div>
													<p class="text-sm text-gray-500">Amount Issued (RM'mil)</p>
													<p class="font-medium">
															{{ optional($bond)->amount_issued ?? 'N/A' }}
													</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Amount Outstanding (RM'mil)</p>
													<p class="font-medium">
															{{ optional($bond)->amount_outstanding ?? 'N/A' }}
													</p>
											</div>
									</div>
							</div>

							<!-- 6. Additional Info -->
							<div class="pt-6 pb-6">
									<h4 class="mb-4 text-lg font-semibold">Additional Info</h4>
									<div class="grid grid-cols-2 gap-4">
											<div>
													<p class="text-sm text-gray-500">Lead Arranger</p>
													<p class="font-medium">{{ optional($bond)->lead_arranger ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Facility Agent</p>
													<p class="font-medium">{{ optional($bond)->facility_agent ?? 'N/A' }}</p>
											</div>

											<div>
												<button x-on:click="$dispatch('open-modal', 'facility-modal')" 
													class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg">
													Show Facility Code
												</button>
											</div>
									</div>
							</div>
						</div>
					</div>
			</div>
			
			<!-- Related Documentations -->
			<div class="bg-white shadow-sm sm:rounded-lg">
					<button @click="openSection = openSection === 'documents' ? null : 'documents'" 
									class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
							<div class="flex items-center justify-between">
									<h3 class="text-xl font-semibold">Related Documentations</h3>
									<svg class="w-6 h-6 transition-transform transform" 
												:class="{ 'rotate-180': openSection === 'documents' }" 
												fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
									</svg>
							</div>
					</button>
					<div x-show="openSection === 'documents'" x-collapse class="border-t border-gray-200">
						<div class="overflow-x-auto rounded-lg">
							<table class="min-w-full divide-y divide-gray-200">
								<thead class="bg-gray-50">
									<tr>
										<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">{{ __('Document Type') }}</th>
										<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">{{ __('Document Name') }}</th>
									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@forelse($documents as $document)
									<tr class="hover:bg-gray-50">
										<td class="px-6 py-4 whitespace-nowrap">
											<span class="px-2 py-1 text-xs text-indigo-800 bg-indigo-100 rounded-full">
												{{ $document->document_type }}
											</span>
										</td>
										<td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
											<a href="{{ asset($document->file_path) }}" 
											class="text-indigo-600 hover:text-indigo-900"
											target="_blank"
											download>
												{{ $document->document_name }}
											</a>
										</td>
									</tr>
									@empty
									<tr>
										<td colspan="2" class="px-6 py-4 text-center text-gray-500">
											{{ __('No documents found') }}
										</td>
									</tr>
									@endforelse
								</tbody>
							</table>

							@if ($documents->hasPages())
									<div class="p-6 border-t">
											{{ $documents->links() }}
									</div>
							@endif
						</div>
					</div>
			</div>

			<!-- Rating Movements -->
			<div class="bg-white shadow-sm sm:rounded-lg">
					<button @click="openSection = openSection === 'ratings' ? null : 'ratings'" 
									class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
							<div class="flex items-center justify-between">
									<h3 class="text-xl font-semibold">Rating Movements</h3>
									<svg class="w-6 h-6 transition-transform transform" 
											:class="{ 'rotate-180': openSection === 'ratings' }" 
											fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
									</svg>
							</div>
					</button>
					<div x-show="openSection === 'ratings'" x-collapse class="border-t border-gray-200">
						<div class="overflow-x-auto rounded-lg">
							<table class="min-w-full divide-y divide-gray-200">
									<thead class="bg-gray-50">
										<tr>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Rating Agency</th>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Effective Date</th>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Rating Tenure</th>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Rating</th>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Rating Action</th>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Rating Outlook</th>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Rating Watch</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
											@forelse($ratingMovements as $rating)
											<tr class="hover:bg-gray-50">
												<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
													{{ $rating->rating_agency ?? N/A }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
													{{ $rating->effective_date->format('d-M-Y') }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap"">
													{{ $rating->rating_tenure }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
													{{ $rating->rating }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
													{{ $rating->rating_action }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
													{{ $rating->rating_outlook }}
												</td>
												<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
													{{ $rating->rating_watch }}
												</td>
											</tr>
											@empty
											<tr>
												<td colspan="7" class="px-6 py-4 text-center text-gray-500">
													No rating history available
												</td>
											</tr>
											@endforelse
									</tbody>
							</table>

							@if ($ratingMovements->hasPages())
									<div class="p-6 border-t">
											{{ $ratingMovements->links() }}
									</div>
							@endif
						</div>
					</div>
			</div>

			<!-- Payment Schedules -->
			<div class="bg-white shadow-sm sm:rounded-lg">
					<button @click="openSection = openSection === 'payments' ? null : 'payments'" 
									class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
							<div class="flex items-center justify-between">
									<h3 class="text-xl font-semibold">Payment Schedules</h3>
									<svg class="w-6 h-6 transition-transform transform" 
											:class="{ 'rotate-180': openSection === 'payments' }" 
											fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
									</svg>
							</div>
					</button>
					<div x-show="openSection === 'payments'" x-collapse class="border-t border-gray-200">
						<div class="overflow-x-auto rounded-lg ">
							<table class="min-w-full divide-y divide-gray-200">
									<thead class="bg-gray-50">
											<tr>
												<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Start Date</th>
												<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">End Date</th>
												<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Payment Date</th>
												<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Ed-Date</th>
												<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Coupon Rate</th>
												<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Adjustment Date</th>
											</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
											@forelse($paymentSchedules as $schedule)
											<tr class="hover:bg-gray-50">
													<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
														{{ $schedule->start_date->format('d-M-Y') }}
													</td>
													<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
														{{ $schedule->end_date->format('d-M-Y') }}
													</td>
													<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
														N/A
													</td>
													<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
														{{ $schedule->ex_date->format('d-M-Y') }}
													</td>
													<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
														{{ $schedule->coupon_rate }}
													</td>
													<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
														{{ $schedule->adjustment_date ?? 'N/A' }}
													</td>
											</tr>
											@empty
											<tr>
												<td colspan="6" class="px-6 py-4 text-center text-gray-500">
													No payment schedules available
												</td>
											</tr>
											@endforelse
									</tbody>
							</table>

							@if ($paymentSchedules->hasPages())
								<div class="p-6 border-t">
									{{ $paymentSchedules->links() }}
								</div>
							@endif
						</div>
					</div>
			</div>

			<!-- Redemption -->
			<div class="bg-white shadow-sm sm:rounded-lg">
				<button @click="openSection = openSection === 'redemption' ? null : 'redemption'" 
								class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
						<div class="flex items-center justify-between">
								<h3 class="text-xl font-semibold">Redemption</h3>
								<svg class="w-6 h-6 transition-transform transform" 
										:class="{ 'rotate-180': openSection === 'redemption' }" 
										fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
								</svg>
						</div>
				</button>
				<div x-show="openSection === 'redemption'" x-collapse class="border-t border-gray-200">
					<div class="p-6 space-y-6">
						<h4 class="mb-4 text-lg font-semibold">Redemption</h4>
						<div class="grid grid-cols-3 gap-4">
							<div>
								<p class="text-sm text-gray-500">Allow Partial Call</p>
								{{-- <p class="font-medium">{{ $redemptions->allow_partial_call ?? 'N/A' }}</p> --}}
							</div>
							<div>
								<p class="text-sm text-gray-500">Last Call Date</p>
								{{-- <p class="font-medium">{{ $redemptions->last_call_date->format('d-M-Y') ?? 'N/A' }}</p> --}}
							</div>
							<div>
								<p class="text-sm text-gray-500">Redeem to Nearest Denomination</p>
								{{-- <p class="font-medium">{{ $redemptions->redeem_nearest_denomination ?? 'N/A' }}</p> --}}
							</div>
						</div>

						<div class="pt-6 border-t">
							<h4 class="mb-4 text-lg font-semibold">Call Schedule</h4>
							<div class="overflow-x-auto border rounded-lg">
								<table class="min-w-full divide-y divide-gray-200">
									<thead class="bg-gray-50">
										<tr>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Start Date</th>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">End Date</th>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Call Price</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
										@forelse($callSchedules as $schedule)
											<tr>
												<td class="px-6 py-4 text-left text-gray-500">
													{{ $schedule->start_date->format('d-M-Y') }}
												</td>
												<td class="px-6 py-4 text-left text-gray-500">
													{{ $schedule->end_date->format('d-M-Y') }}
												</td>
												<td class="px-6 py-4 text-left text-gray-500">
													{{ $schedule->call_price }}
												</td>
											</tr>
										@empty
											<tr>
												<td colspan="3" class="px-6 py-4 text-center text-gray-500">
													No payment schedules available
												</td>
											</tr>
										@endforelse
									</tbody>
								</table>

								@if ($callSchedules->hasPages())
									<div class="p-6 border-t">
										{{ $callSchedules->links() }}
									</div>
								@endif
							</div>
						</div>
						
						<div class="pt-6 border-t">
							<h4 class="mb-4 text-lg font-semibold">Lockout Periods</h4>
								<div class="overflow-x-auto border rounded-lg">
								<table class="min-w-full divide-y divide-gray-200">
									<thead class="bg-gray-50">
										<tr>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Start Date</th>
											<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">End Date</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
										@forelse($lockoutPeriods as $period)
											<tr>
												<td class="px-6 py-4 text-left text-gray-500">{{ $period->start_date->format('d-M-Y') }}</td>
												<td class="px-6 py-4 text-left text-gray-500">{{ $period->end_date->format('d-M-Y') }}</td>
											</tr>
										@empty
											<tr>
												<td colspan="3" class="px-6 py-4 text-center text-gray-500">
													No lockout periods defined
												</td>
											</tr>
										@endforelse
									</tbody>
								</table>

								@if ($lockoutPeriods->hasPages())
									<div class="p-6 border-t">
										{{ $lockoutPeriods->links() }}
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Trading Activities -->
			<div class="bg-white shadow-sm sm:rounded-lg">
				<button @click="openSection = openSection === 'trading' ? null : 'trading'" 
								class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
						<div class="flex items-center justify-between">
								<h3 class="text-xl font-semibold">Trading Activities</h3>
								<svg class="w-6 h-6 transition-transform transform" 
										:class="{ 'rotate-180': openSection === 'trading' }" 
										fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
								</svg>
						</div>
				</button>
				<div x-show="openSection === 'trading'" x-collapse class="border-t border-gray-200">
					<div class="overflow-x-auto rounded-lg">
						<table class="min-w-full divide-y divide-gray-200">
								<thead class="bg-gray-50">
									<tr>
										<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Trade Date</th>
										<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Input Time</th>
										<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Amount (RM'mil)</th>
										<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Price</th>
										<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Yield(%)</th>
										<th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Value Date</th>
									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@forelse($tradingActivities as $activity)
									<tr class="hover:bg-gray-50">
											<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
												{{ $activity->trade_date->format('d-M-Y') }}
											</td>
											<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
												{{ $activity->input_time->format('h:m:s A') }}
											</td>
											<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
												{{ number_format($activity->amount, 0) }}
											</td>
											<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
												{{ number_format($activity->price, 2) }}
											</td>
											<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
												{{ number_format($activity->yield, 2) }}%
											</td>
											<td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
												{{ $activity->value_date->format('d-m-Y') }}M
											</td>
									</tr>
									@empty
									<tr>
											<td colspan="6" class="px-6 py-4 text-center text-gray-500">
													No trading activities recorded
											</td>
									</tr>
									@endforelse
								</tbody>
						</table>

						@if ($tradingActivities->hasPages())
							<div class="p-6 border-t">
								{{ $tradingActivities->links() }}
							</div>
						@endif
					</div>
				</div>
			</div>

			<!-- Charts -->
			<div class="bg-white shadow-sm sm:rounded-lg">
					<button @click="openSection = openSection === 'charts' ? null : 'charts'" 
									class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
							<div class="flex items-center justify-between">
									<h3 class="text-xl font-semibold">Charts</h3>
									<svg class="w-6 h-6 transition-transform transform" 
											:class="{ 'rotate-180': openSection === 'charts' }" 
											fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
									</svg>
							</div>
					</button>
					<div x-show="openSection === 'charts'" x-collapse class="border-t border-gray-200">
							<div class="p-6">
									<!-- Assuming charts data is an array of objects with properties for rendering -->
									@foreach($charts as $chart)
											<div class="mb-4">
													<h4 class="text-lg font-semibold">{{ $chart->title }}</h4>
													<div>
															<!-- Render chart here, e.g., using a chart library -->
															<canvas id="chart-{{ $chart->id }}" width="400" height="200"></canvas>
													</div>
											</div>
									@endforeach
							</div>
					</div>
			</div>
		</div>
	</div>

	<x-modal name="facility-modal">
		<div class="p-6">
			<h2 class="text-lg font-semibold">General Information</h2>
	
			<div class="mt-4 space-y-2">
				<div>
					<p class="text-sm text-gray-500">Facility Code</p>
					<p class="font-medium">{{ optional($bond)->facility_code ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Facility Number</p>
					<p class="font-medium">{{ optional($bond)->facility_number ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Principle</p>
					<p class="font-medium">{{ optional($bond)->principle ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Islamic Concept</p>
					<p class="font-medium">{{ optional($bond)->islamic_concept ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Maturity Date</p>
					<p class="font-medium">{{ optional($bond)->maturity_date ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Instrument</p>
					<p class="font-medium">{{ optional($bond)->instrument ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Instrument Type</p>
					<p class="font-medium">{{ optional($bond)->instrument_type ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Guaranteed</p>
					<p class="font-medium">{{ optional($bond)->guaranteed ? 'True' : 'False' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Total Guaranteed (RM)</p>
					<p class="font-medium">{{ number_format(optional($bond)->total_guaranteed, 2) ?? '0.00' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Indicator</p>
					<p class="font-medium">{{ optional($bond)->indicator ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Facility Rating</p>
					<p class="font-medium">{{ optional($bond)->facility_rating ?? 'N/A' }}</p>
				</div>
			</div>
	
			<h2 class="mt-6 text-lg font-semibold">Facility Information</h2>
	
			<div class="mt-4 space-y-2">
				<div>
					<p class="text-sm text-gray-500">Facility Amount (RM)</p>
					<p class="font-medium">{{ number_format(optional($bond)->facility_amount, 2) ?? '0.00' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Available Limit (RM)</p>
					<p class="font-medium">{{ number_format(optional($bond)->available_limit, 2) ?? '0.00' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Trustee/Security Agent</p>
					<p class="font-medium">{{ optional($bond)->trustee_security_agent ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Lead Arranger (LA)</p>
					<p class="font-medium">{{ optional($bond)->lead_arranger ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Availability</p>
					<p class="font-medium">{{ optional($bond)->availability ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Outstanding (RM)</p>
					<p class="font-medium">{{ number_format(optional($bond)->outstanding, 2) ?? '0.00' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Facility Agent (FA)</p>
					<p class="font-medium">{{ optional($bond)->facility_agent ?? 'N/A' }}</p>
				</div>
			</div>
	
			<!-- Close Button -->
			<button x-on:click="$dispatch('close-modal', 'facility-modal')" 
					class="px-4 py-2 mt-4 text-sm bg-gray-200 rounded-lg">
				Close
			</button>
		</div>
	</x-modal>
</x-main-layout>