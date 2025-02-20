<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Issuer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('issuers.store') }}" method="POST" class="p-6">
                    @csrf

                    <!-- Section: Issuer Details -->
                    <div class="space-y-6 pb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Issuer Details</h3>

                        <!-- Row 1: Full Name -->
                        <div>
                            <label for="issuer_name" class="block text-sm font-medium text-gray-700">Issuer Name *</label>
                            <input type="text" name="issuer_name" id="issuer_name" 
                                value="{{ old('issuer_name') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Row 2: Short Name, Registration Number -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="issuer_short_name" class="block text-sm font-medium text-gray-700">Short Name *</label>
                                <input type="text" name="issuer_short_name" id="issuer_short_name" 
                                    value="{{ old('issuer_short_name') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="registration_number" class="block text-sm font-medium text-gray-700">Registration Number *</label>
                                <input type="text" name="registration_number" id="registration_number" 
                                    value="{{ old('registration_number') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 3: Debenture Number, Trust Deed Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="debenture_number" class="block text-sm font-medium text-gray-700">Debenture Number *</label>
                                <input type="text" name="debenture_number" id="debenture_number" 
                                    value="{{ old('debenture_number') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="trust_deed_date" class="block text-sm font-medium text-gray-700">Trust Deed Date *</label>
                                <input type="date" name="trust_deed_date" id="trust_deed_date" 
                                    value="{{ old('trust_deed_date') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Trustee Information -->
                    <div class="space-y-6 pb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Trustee Information</h3>

                        <!-- Row 1: Role 1, Fee Amount 1 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="role_1" class="block text-sm font-medium text-gray-700">Role 1 *</label>
                                <input type="text" name="role_1" id="role_1" 
                                    value="{{ old('role_1') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="fee_amount_1" class="block text-sm font-medium text-gray-700">Fee Amount 1 *</label>
                                <input type="number" name="fee_amount_1" id="fee_amount_1" 
                                    value="{{ old('fee_amount_1') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: Role 2, Fee Amount 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="role_2" class="block text-sm font-medium text-gray-700">Role 2 *</label>
                                <input type="text" name="role_2" id="role_2" 
                                    value="{{ old('role_2') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="fee_amount_2" class="block text-sm font-medium text-gray-700">Fee Amount 2 *</label>
                                <input type="number" name="fee_amount_2" id="fee_amount_2" 
                                    value="{{ old('fee_amount_2') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Reminder Dates -->
                    <div class="space-y-6 pb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Reminder Dates</h3>

                        <!-- Row 1: Reminder 1 -->
                        <div>
                            <label for="reminder_1" class="block text-sm font-medium text-gray-700">Reminder 1 *</label>
                            <input type="date" name="reminder_1" id="reminder_1" 
                                value="{{ old('reminder_1') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Row 2: Reminder 2 -->
                        <div>
                            <label for="reminder_2" class="block text-sm font-medium text-gray-700">Reminder 2 *</label>
                            <input type="date" name="reminder_2" id="reminder_2" 
                                value="{{ old('reminder_2') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Row 3: Reminder 3 -->
                        <div>
                            <label for="reminder_3" class="block text-sm font-medium text-gray-700">Reminder 3 *</label>
                            <input type="date" name="reminder_3" id="reminder_3" 
                                value="{{ old('reminder_3') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('issuers.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Issuer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>