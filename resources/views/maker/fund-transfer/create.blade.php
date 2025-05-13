<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Placement & Fund Transfers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if ($errors->any())
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
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with
                                your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form action="{{ route('fund-transfer-m.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="pb-6 space-y-6">
                        <!-- Basic Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Basic Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Date -->
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700">Date *</label>
                                    <input type="date" name="date" id="date" required
                                        value="{{ old('date') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Details -->
                                <div>
                                    <label for="details"
                                        class="block text-sm font-medium text-gray-700">Details</label>
                                    <textarea name="details" id="details" rows="4"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('details') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Amounts Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Amount Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Placement Amount -->
                                <div>
                                    <label for="placement_amount"
                                        class="block text-sm font-medium text-gray-700">Placement/Withdrawal Amount (RM)
                                        *</label>
                                    <input type="number" name="placement_amount" id="placement_amount" required
                                        step="0.01" value="{{ old('placement_amount') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Fund Transfer Amount -->
                                <div>
                                    <label for="fund_transfer_amount"
                                        class="block text-sm font-medium text-gray-700">Fund Transfer Amount
                                        (RM)</label>
                                    <input type="number" name="fund_transfer_amount" id="fund_transfer_amount"
                                        step="0.01" value="{{ old('fund_transfer_amount') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-gray-200">
                        <a href="{{ route('fund-transfer-m.index') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Placement & Fund Transfer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
