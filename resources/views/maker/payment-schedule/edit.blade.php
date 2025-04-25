<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Payment Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if($errors->any())
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form action="{{ route('payment-m.update', $payment) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="pb-6 space-y-6">
                        <!-- Bond Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Bond Information</h3>
                            <div>
                                <label for="bond_id" class="block text-sm font-medium text-gray-700">Bond *</label>
                                <select name="bond_id" id="bond_id" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Select Bond --</option>
                                    @foreach($bonds as $bond)
                                        <option value="{{ $bond->id }}" @selected(old('bond_id', $payment->bond_id) == $bond->id)>
                                            {{ $bond->isin_code }} - {{ $bond->bond_sukuk_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Coupon Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Coupon Information</h3>
                            <div>
                                <label for="coupon_rate" class="block text-sm font-medium text-gray-700">Coupon Rate (%)</label>
                                <input type="number" step="0.01" name="coupon_rate" id="coupon_rate" 
                                    value="{{ old('coupon_rate', $payment->coupon_rate) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="e.g., 5.25">
                            </div>
                        </div>
                        
                        <!-- Period Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Period Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date *</label>
                                    <input type="date" name="start_date" id="start_date" 
                                        value="{{ old('start_date', $payment->start_date?->format('Y-m-d')) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date *</label>
                                    <input type="date" name="end_date" id="end_date" 
                                        value="{{ old('end_date', $payment->end_date?->format('Y-m-d')) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Payment Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="ex_date" class="block text-sm font-medium text-gray-700">Ex-Date</label>
                                    <input type="date" name="ex_date" id="ex_date" 
                                        value="{{ old('ex_date', $payment->ex_date?->format('Y-m-d')) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date *</label>
                                    <input type="date" name="payment_date" id="payment_date" 
                                        value="{{ old('payment_date', $payment->payment_date?->format('Y-m-d')) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Additional Information</h3>
                            <div>
                                <label for="adjustment_date" class="block text-sm font-medium text-gray-700">Adjustment Date</label>
                                <input type="date" name="adjustment_date" id="adjustment_date" 
                                    value="{{ old('adjustment_date', $payment->adjustment_date?->format('Y-m-d')) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">Optional. Leave blank if no adjustment date applies.</p>
                            </div>
                        </div>

                        <div>
                            <label for="reminder_total_date" class="block text-sm font-medium text-gray-700">Reminder (Days Before Payment Date)</label>
                            <input type="number" name="reminder_total_date" id="reminder_total_date"
                                value="{{ old('reminder_total_date', $payment->reminder_total_date ?? '') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g., 15 or 30">
                            <p class="mt-1 text-sm text-gray-500">Enter how many days before payment to send a reminder.</p>
                        </div>
                        
                        
                        <!-- System Information -->
                        <div>
                            <h3 class="mb-4 text-lg font-medium text-gray-900">System Information</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $payment->created_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $payment->updated_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('bond-m.show', $payment->bond) }}" 
                           class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Payment Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>