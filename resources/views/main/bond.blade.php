<x-main-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Security Information') }}
		</h2>
	</x-slot>

	<div class="py-8">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
			<h1 class="font-bold text-xl">{{ $bond->bond_sukuk_name }} - {{ $bond->sub_name }}</h1>
			<p class="text-grey-800 leading-light">Issuer Name: {{ $bond->issuer->issuer_name }}</p>
		</div>
	</div>

	<div x-data="{ openSection: 'bonds' }">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
			<!-- Bond + Sukuk Information -->
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
					<div x-show="openSection === 'bonds'" x-collapse class="border-t border-gray-200">
						<div class="p-6 space-y-6 divide-y divide-gray-200">
							<!-- 1. Security Information -->
							<div class="pb-6">
									<h4 class="text-lg font-semibold mb-4">Security Information</h4>
									<div class="grid grid-cols-2 gap-4">
											<div>
													<p class="text-sm text-gray-500">Principal</p>
													<p class="font-medium">
															{{ optional($bond->bondInfo)->principal ? number_format(optional($bond->bondInfo)->principal, 2) : 'N/A' }}
													</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">ISIN Code</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->isin_code ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Islamic Concept</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->islamic_concept ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Stock Code</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->stock_code ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Instrument Code</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->instrument_code ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Category</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->category ?? 'N/A' }}</p>
											</div>
											
											<div>
													<p class="text-sm text-gray-500">Issue Date</p>
													<p class="font-medium">{{ $bond->bondInfo?->issue_date?->format('d/m/Y') ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Maturity Date</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->maturity_date ? optional($bond->bondInfo)->maturity_date->format('d/m/Y') : 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Coupon Rate</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->coupon_rate?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Coupon Type</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->coupon_type ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Coupon Frequency</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->coupon_frequency ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Day Count</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->day_count ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Issue Tenure (Years)</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->issue_tenure_years ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Residual Tenure (Years)</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->residual_tenure_years ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Sub Category</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->sub_category ?? 'N/A' }}</p>
											</div>
									</div>
							</div>

							<!-- 2. Coupon Payment Details -->
							<div class="pt-6 pb-6">
								<h4 class="text-lg font-semibold mb-4">Coupon Payment Details</h4>
								<div class="grid grid-cols-2 gap-4">
									<div>
										<p class="text-sm text-gray-500">Coupon Accrual</p>
										<p class="font-medium">{{ optional($bond->bondInfo)->coupon_accrual ?? 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">Prev Coupon Payment Date</p>
										<p class="font-medium">{{ optional($bond->bondInfo)->prev_coupon_payment_date ? optional($bond->bondInfo)->prev_coupon_payment_date->format('d-M-Y') : 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">First Coupon Payment Date</p>
										<p class="font-medium">{{ optional($bond->bondInfo)->first_coupon_payment_date ? optional($bond->bondInfo)->first_coupon_payment_date->format('d-M-Y') : 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">Next Coupon Payment Date</p>
										<p class="font-medium">{{ optional($bond->bondInfo)->next_coupon_payment_date ? optional($bond->bondInfo)->next_coupon_payment_date->format('d-M-Y') : 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">Last Coupon Payment Date</p>
										<p class="font-medium">{{ optional($bond->bondInfo)->last_coupon_payment_date ? optional($bond->bondInfo)->last_coupon_payment_date->format('d-M-Y') : 'N/A' }}</p>
									</div>
								</div>
							</div>

							<!-- 3. Latest Trading -->
							<div class="pt-6 pb-6">
									<h4 class="text-lg font-semibold mb-4">Latest Trading</h4>
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
									<h4 class="text-lg font-semibold mb-4">Ratings</h4>
									<div class="space-y-2">
											@forelse($ratingMovements as $rating)
											<div class="flex items-center space-x-4">
													<span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
															{{ $rating->rating ?? 'N/A' }}
													</span>
													<span class="text-sm">{{ $rating->rating_agency ?? 'N/A' }}</span>
													<span class="text-sm text-gray-500">
															{{ optional($rating->effective_date)->format('M Y') ?? 'N/A' }}
													</span>
											</div>
											@empty
												<p class="text-gray-500">No ratings available</p>
											@endforelse
									</div>
							</div>

							<!-- 5. Issuance -->
							<div class="pt-6 pb-6">
									<h4 class="text-lg font-semibold mb-4">Issuance</h4>
									<div class="grid grid-cols-2 gap-4">
											<div>
													<p class="text-sm text-gray-500">Amount Issued (RM'mil)</p>
													<p class="font-medium">
															{{ optional($bond->bondInfo)->amount_issued ?? 'N/A' }}
													</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Amount Outstanding (RM'mil)</p>
													<p class="font-medium">
															{{ optional($bond->bondInfo)->amount_outstanding ?? 'N/A' }}
													</p>
											</div>
									</div>
							</div>

							<!-- 6. Additional Info -->
							<div class="pt-6 pb-6">
									<h4 class="text-lg font-semibold mb-4">Additional Info</h4>
									<div class="grid grid-cols-2 gap-4">
											<div>
													<p class="text-sm text-gray-500">Lead Arranger</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->lead_arranger ?? 'N/A' }}</p>
											</div>
											<div>
													<p class="text-sm text-gray-500">Facility Agent</p>
													<p class="font-medium">{{ optional($bond->bondInfo)->facility_agent ?? 'N/A' }}</p>
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
							<div class="flex justify-between items-center">
									<h3 class="text-xl font-semibold">Related Documentations</h3>
									<svg class="w-6 h-6 transform transition-transform" 
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
										<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Document Type') }}</th>
										<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Document Name') }}</th>
									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@forelse($documents as $document)
									<tr class="hover:bg-gray-50">
										<td class="px-6 py-4 whitespace-nowrap">
											<span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs">
												{{ $document->document_type }}
											</span>
										</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
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
							<div class="flex justify-between items-center">
									<h3 class="text-xl font-semibold">Rating Movements</h3>
									<svg class="w-6 h-6 transform transition-transform" 
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
											<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating Agency</th>
											<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Effective Date</th>
											<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating Tenure</th>
											<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
											<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating Action</th>
											<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating Outlook</th>
											<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating Watch</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
											@forelse($ratingMovements as $rating)
											<tr class="hover:bg-gray-50">
												<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
													{{ $rating->rating_agency ?? N/A }}
												</td>
												<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
													{{ $rating->effective_date->format('d-M-Y') }}
												</td>
												<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"">
													{{ $rating->rating_tenure }}
												</td>
												<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
													{{ $rating->rating }}
												</td>
												<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
													{{ $rating->rating_action }}
												</td>
												<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
													{{ $rating->rating_outlook }}
												</td>
												<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
							<div class="flex justify-between items-center">
									<h3 class="text-xl font-semibold">Payment Schedules</h3>
									<svg class="w-6 h-6 transform transition-transform" 
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
												<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
												<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Date</th>
												<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Date</th>
												<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ed-Date</th>
												<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coupon Rate</th>
												<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adjustment Date</th>
											</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
											@forelse($paymentSchedules as $schedule)
											<tr class="hover:bg-gray-50">
													<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
														{{ $schedule->start_date->format('d-M-Y') }}
													</td>
													<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
														{{ $schedule->end_date->format('d-M-Y') }}
													</td>
													<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
														N/A
													</td>
													<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
														{{ $schedule->ex_date->format('d-M-Y') }}
													</td>
													<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
														{{ $schedule->coupon_rate }}
													</td>
													<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
						<div class="flex justify-between items-center">
								<h3 class="text-xl font-semibold">Redemption</h3>
								<svg class="w-6 h-6 transform transition-transform" 
										:class="{ 'rotate-180': openSection === 'redemption' }" 
										fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
								</svg>
						</div>
				</button>
				<div x-show="openSection === 'redemption'" x-collapse class="border-t border-gray-200">
					<div class="p-6 space-y-6">
							@foreach($redemptions as $redemption)
							<div class="space-y-4">
								<h4 class="text-lg font-semibold mb-4">Redemption</h4>
								<div class="grid grid-cols-3 gap-4">
									<div>
										<p class="text-sm text-gray-500">Allow Partial Call</p>
										<p class="font-medium">{{ $redemption->allow_partial_call ?? 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">Last Call Date</p>
										<p class="font-medium">RM {{ $redemption->last_call_date ?? 'N/A' }}</p>
									</div>
									<div>
										<p class="text-sm text-gray-500">Redeem to Nearest Denomination</p>
										<p class="font-medium">RM {{ $redemption->redeem_nearest_denomination ?? 'N/A' }}</p>
									</div>
								</div>

								<div class="border-t pt-6">
									<h4 class="text-lg font-semibold mb-4">Call Schedule</h4>
									<div class="overflow-x-auto rounded-lg border">
										<table class="min-w-full divide-y divide-gray-200">
											<thead class="bg-gray-50">
												<tr>
													<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
													<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Date</th>
													<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Call Price</th>
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
								
								<div class="border-t pt-6">
									<h4 class="text-lg font-semibold mb-4">Lockout Periods</h4>
										<div class="overflow-x-auto rounded-lg border">
										<table class="min-w-full divide-y divide-gray-200">
											<thead class="bg-gray-50">
												<tr>
													<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
													<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Date</th>
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
							@endforeach
					</div>
				</div>
			</div>

			<!-- Trading Activities -->
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
				<div x-show="openSection === 'trading'" x-collapse class="border-t border-gray-200">
					<div class="overflow-x-auto rounded-lg">
						<table class="min-w-full divide-y divide-gray-200">
								<thead class="bg-gray-50">
									<tr>
										<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trade Date</th>
										<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Input Time</th>
										<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount (RM'mil)</th>
										<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
										<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Yield(%)</th>
										<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value Date</th>
									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@forelse($tradingActivities as $activity)
									<tr class="hover:bg-gray-50">
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
												{{ $activity->trade_date->format('d-M-Y') }}
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
												{{ $activity->input_time->format('h:m:s A') }}
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
												{{ number_format($activity->amount, 0) }}
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
												{{ number_format($activity->price, 2) }}
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
												{{ number_format($activity->yield, 2) }}%
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
							<div class="flex justify-between items-center">
									<h3 class="text-xl font-semibold">Charts</h3>
									<svg class="w-6 h-6 transform transition-transform" 
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
</x-main-layout>