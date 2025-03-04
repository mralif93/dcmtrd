<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Issuer Details') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded shadow-sm transition-all duration-300">
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

            <!-- Main Content -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg transition-all duration-300 hover:shadow-lg">
                <!-- Section: Issuer Details -->
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 pb-2 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900">Issuer Details</h3>
                        <p class="mt-1 text-sm text-gray-500">Basic information about the issuer.</p>
                    </div>
                    
                    <dl class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $issuer->issuer_name ?? 'N/A' }}</dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Short Name</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $issuer->issuer_short_name ?? 'N/A' }}</dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Registration Number</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $issuer->registration_number ?? 'N/A' }}</dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Debenture Number</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $issuer->debenture ?? 'N/A' }}</dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Trust Deed Date</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $issuer->trust_deed_date ? $issuer->trust_deed_date->format('d/m/Y') : 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Section: Trustee Information -->
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 pb-2 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900">Trustee Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Details about trustee roles and fees.</p>
                    </div>
                    
                    <dl class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2">
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Role 1</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $issuer->trustee_role_1 ?? 'N/A' }}</dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Fee Amount 1</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                @if($issuer->trustee_fee_amount_1)
                                    <span class="font-mono">RM{{ number_format($issuer->trustee_fee_amount_1, 2) }}</span>
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Role 2</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $issuer->trustee_role_2 ?? 'N/A' }}</dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Fee Amount 2</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                @if($issuer->trustee_fee_amount_2)
                                    <span class="font-mono">RM{{ number_format($issuer->trustee_fee_amount_2, 2) }}</span>
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Section: Reminder Dates -->
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 pb-2 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900">Reminder Dates</h3>
                        <p class="mt-1 text-sm text-gray-500">Important dates for reminders.</p>
                    </div>
                    
                    <dl class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-3">
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Reminder 1</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $issuer->reminder_1 ? $issuer->reminder_1->format('d/m/Y') : 'N/A' }}
                            </dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Reminder 2</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $issuer->reminder_2 ? $issuer->reminder_2->format('d/m/Y') : 'N/A' }}
                            </dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Reminder 3</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $issuer->reminder_3 ? $issuer->reminder_3->format('d/m/Y') : 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Section: System Information -->
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 pb-2 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900">System Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Record creation and modification details.</p>
                    </div>
                    
                    <dl class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2">
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $issuer->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $issuer->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Actions -->
                <div class="p-4 sm:p-6 bg-white">
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('issuers.index') }}" 
                        class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('issuers.edit', $issuer) }}" 
                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Issuer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>