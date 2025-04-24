<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Issuer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if ($errors->any() || session('error'))
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
                            @if ($errors->any())
                                <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors
                                    with your submission</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="pl-5 space-y-1 list-disc">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('error'))
                                <h3 class="text-sm font-medium text-red-800">Error</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form action="{{ route('issuer-m.update', $issuer) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="pb-6 space-y-6">
                        <!-- Basic Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Basic Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="issuer_name" class="block text-sm font-medium text-gray-700">Issuer Name
                                        *</label>
                                    <input type="text" name="issuer_name" id="issuer_name"
                                        value="{{ old('issuer_name', $issuer->issuer_name) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('issuer_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="issuer_short_name" class="block text-sm font-medium text-gray-700">Short
                                        Name *</label>
                                    <input type="text" name="issuer_short_name" id="issuer_short_name"
                                        value="{{ old('issuer_short_name', $issuer->issuer_short_name) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('issuer_short_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="registration_number"
                                        class="block text-sm font-medium text-gray-700">Registration Number *</label>
                                    <input type="text" name="registration_number" id="registration_number"
                                        value="{{ old('registration_number', $issuer->registration_number) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('registration_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div x-data="{ debenture: '{{ old('debenture', $issuer->debenture) }}', customDebenture: '' }">
                                    <label for="debenture"
                                        class="block text-sm font-medium text-gray-700">Debenture</label>

                                    <select id="debenture" name="debenture" x-model="debenture"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="" disabled>Select an option</option>
                                        <option value="Corporate Bond">Corporate Bond</option>
                                        <option value="Corporate Trust">Corporate Trust</option>
                                        <option value="Loan">Loan</option>
                                        <option value="Other">Other</option>
                                    </select>

                                    <!-- Show this only when "Other" is selected -->
                                    <template x-if="debenture === 'Other'">
                                        <input type="text" name="debenture_custom" x-model="customDebenture"
                                            class="block w-full mt-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="Enter custom debenture type" />
                                    </template>

                                    @error('debenture')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="trust_deed_date" class="block text-sm font-medium text-gray-700">Trust
                                        Deed Date</label>
                                    <input type="date" name="trust_deed_date" id="trust_deed_date"
                                        value="{{ old('trust_deed_date', optional($issuer->trust_deed_date)->format('Y-m-d')) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trust_deed_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="trust_amount_escrow_sum"
                                        class="block text-sm font-medium text-gray-700">Trust Amount/Escrow Sum</label>
                                    <input type="text" name="trust_amount_escrow_sum" id="trust_amount_escrow_sum"
                                        value="{{ old('trust_amount_escrow_sum', $issuer->trust_amount_escrow_sum) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trust_amount_escrow_sum')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Share Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Share Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="no_of_share" class="block text-sm font-medium text-gray-700">Number of
                                        Shares</label>
                                    <input type="number" name="no_of_share" id="no_of_share"
                                        value="{{ old('no_of_share', $issuer->no_of_share) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('no_of_share')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="outstanding_size"
                                        class="block text-sm font-medium text-gray-700">Outstanding Size</label>
                                    <input type="number" name="outstanding_size" id="outstanding_size"
                                        value="{{ old('outstanding_size', $issuer->outstanding_size) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('outstanding_size')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Trustee Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Trustee Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="trustee_role_1" class="block text-sm font-medium text-gray-700">Role
                                        1</label>
                                    <input type="text" name="trustee_role_1" id="trustee_role_1"
                                        value="{{ old('trustee_role_1', $issuer->trustee_role_1) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_role_1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="trustee_role_2" class="block text-sm font-medium text-gray-700">Role
                                        2</label>
                                    <input type="text" name="trustee_role_2" id="trustee_role_2"
                                        value="{{ old('trustee_role_2', $issuer->trustee_role_2) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_role_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Person Info Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Contact Person Info</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="pic_name" class="block text-sm font-medium text-gray-700">PIC
                                        Name</label>
                                    <input type="text" name="pic_name" id="pic_name"
                                        value="{{ old('pic_name', $issuer->pic_name) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('pic_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="phone_no" class="block text-sm font-medium text-gray-700">Phone
                                        Number</label>
                                    <input type="text" name="phone_no" id="phone_no"
                                        value="{{ old('phone_no', $issuer->phone_no) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('phone_no')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea name="address" id="address" rows="3"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $issuer->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
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
                                        {{ $issuer->created_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $issuer->updated_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                @if ($issuer->prepared_by)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $issuer->prepared_by }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($issuer->verified_by)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $issuer->verified_by }}
                                        </dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $issuer->status }}
                                    </dd>
                                </div>
                                @if ($issuer->approval_datetime)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($issuer->approval_datetime)->format('d/m/Y H:i') }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($issuer->remarks)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $issuer->remarks }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('maker.dashboard', ['section' => 'dcmtrd']) }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Issuer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
