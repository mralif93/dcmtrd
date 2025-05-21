<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Chnage to Withdrawal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if ($errors->any())
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your
                        submission</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form action="{{ route('send-documents-a.approval', $security->id) }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        <!-- Status (Readonly, Pre-set to Withdrawal) -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <input type="text" id="status_display" value="Withdrawal" disabled
                                class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <input type="hidden" name="status" value="Withdrawal">
                        </div>

                        <!-- Withdrawal Date -->
                        <div>
                            <label for="withdrawal_date" class="block text-sm font-medium text-gray-700">Withdrawal Date
                                *</label>
                            <input type="date" name="withdrawal_date" id="withdrawal_date" required
                                value="{{ old('withdrawal_date') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('list-security-request-a.show') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Save Security
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
