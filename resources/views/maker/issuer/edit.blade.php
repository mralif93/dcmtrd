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
                <form action="{{ route('issuer-m.update', $issuer) }}" method="POST" class="p-6">
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
                                <div>
                                    <label for="trust_amount_escrow_sum" class="block text-sm font-medium text-gray-700">Trust Amount/Escrow Sum</label>
                                    <input type="text" name="trust_amount_escrow_sum" id="trust_amount_escrow_sum" 
                                        value="{{ old('trust_amount_escrow_sum', $issuer->trust_amount_escrow_sum) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trust_amount_escrow_sum')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Share Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Share Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="no_of_share" class="block text-sm font-medium text-gray-700">Number of Shares</label>
                                    <input type="text" name="no_of_share" id="no_of_share" 
                                        value="{{ old('no_of_share', $issuer->no_of_share) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('no_of_share')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="outstanding_size" class="block text-sm font-medium text-gray-700">Outstanding Size</label>
                                    <input type="text" name="outstanding_size" id="outstanding_size" 
                                        value="{{ old('outstanding_size', $issuer->outstanding_size) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('outstanding_size')
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
                                    <label for="trustee_role_2" class="block text-sm font-medium text-gray-700">Role 2</label>
                                    <input type="text" name="trustee_role_2" id="trustee_role_2" 
                                        value="{{ old('trustee_role_2', $issuer->trustee_role_2) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_role_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
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
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $issuer->status }}
                                    </dd>
                                </div>
                                @if($issuer->approval_datetime)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($issuer->approval_datetime)->format('d/m/Y H:i') }}
                                    </dd>
                                </div>
                                @endif
                                @if($issuer->remarks)
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
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('maker.dashboard', ['section' => 'dcmtrd']) }}" 
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