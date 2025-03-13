<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Issuer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if($errors->any() || session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            @if($errors->any())
                                <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            @if(session('error'))
                                <h3 class="text-sm font-medium text-red-800">Error</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('issuers-info.update', $issuer) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6 pb-6">
                        <!-- Basic Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="issuer_name" class="block text-sm font-medium text-gray-700">Issuer Name *</label>
                                    <input type="text" name="issuer_name" id="issuer_name" 
                                        value="{{ old('issuer_name', $issuer->issuer_name) }}" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('issuer_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="issuer_short_name" class="block text-sm font-medium text-gray-700">Short Name *</label>
                                    <input type="text" name="issuer_short_name" id="issuer_short_name" 
                                        value="{{ old('issuer_short_name', $issuer->issuer_short_name) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('issuer_short_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="registration_number" class="block text-sm font-medium text-gray-700">Registration Number *</label>
                                    <input type="text" name="registration_number" id="registration_number" 
                                        value="{{ old('registration_number', $issuer->registration_number) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('registration_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="debenture" class="block text-sm font-medium text-gray-700">Debenture</label>
                                    <input type="text" name="debenture" id="debenture" 
                                        value="{{ old('debenture', $issuer->debenture) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('debenture')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="trust_deed_date" class="block text-sm font-medium text-gray-700">Trust Deed Date</label>
                                    <input type="date" name="trust_deed_date" id="trust_deed_date" 
                                        value="{{ old('trust_deed_date', optional($issuer->trust_deed_date)->format('Y-m-d')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trust_deed_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Trustee Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Trustee Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="trustee_role_1" class="block text-sm font-medium text-gray-700">Role 1</label>
                                    <input type="text" name="trustee_role_1" id="trustee_role_1" 
                                        value="{{ old('trustee_role_1', $issuer->trustee_role_1) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_role_1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="trustee_fee_amount_1" class="block text-sm font-medium text-gray-700">Fee Amount 1 (RM)</label>
                                    <input type="number" step="0.01" name="trustee_fee_amount_1" id="trustee_fee_amount_1" 
                                        value="{{ old('trustee_fee_amount_1', $issuer->trustee_fee_amount_1) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_fee_amount_1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="trustee_role_2" class="block text-sm font-medium text-gray-700">Role 2</label>
                                    <input type="text" name="trustee_role_2" id="trustee_role_2" 
                                        value="{{ old('trustee_role_2', $issuer->trustee_role_2) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_role_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="trustee_fee_amount_2" class="block text-sm font-medium text-gray-700">Fee Amount 2 (RM)</label>
                                    <input type="number" step="0.01" name="trustee_fee_amount_2" id="trustee_fee_amount_2" 
                                        value="{{ old('trustee_fee_amount_2', $issuer->trustee_fee_amount_2) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_fee_amount_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Reminder Dates Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Reminder Dates</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="reminder_1" class="block text-sm font-medium text-gray-700">Reminder 1</label>
                                    <input type="date" name="reminder_1" id="reminder_1" 
                                        value="{{ old('reminder_1', optional($issuer->reminder_1)->format('Y-m-d')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('reminder_1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="reminder_2" class="block text-sm font-medium text-gray-700">Reminder 2</label>
                                    <input type="date" name="reminder_2" id="reminder_2" 
                                        value="{{ old('reminder_2', optional($issuer->reminder_2)->format('Y-m-d')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('reminder_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="reminder_3" class="block text-sm font-medium text-gray-700">Reminder 3</label>
                                    <input type="date" name="reminder_3" id="reminder_3" 
                                        value="{{ old('reminder_3', optional($issuer->reminder_3)->format('Y-m-d')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('reminder_3')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status Section (Admin may want to change status) -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Status</h3>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Active" {{ old('status', $issuer->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Pending" {{ old('status', $issuer->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Rejected" {{ old('status', $issuer->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="Inactive" {{ old('status', $issuer->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mt-4">
                                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                <textarea name="remarks" id="remarks" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks', $issuer->remarks) }}</textarea>
                                @error('remarks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- System Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
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
                                @if($issuer->prepared_by)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $issuer->prepared_by }}
                                    </dd>
                                </div>
                                @endif
                                @if($issuer->verified_by)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $issuer->verified_by }}
                                    </dd>
                                </div>
                                @endif
                                @if($issuer->approval_datetime)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($issuer->approval_datetime)->format('d/m/Y H:i') }}
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('issuers-info.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Issuer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>