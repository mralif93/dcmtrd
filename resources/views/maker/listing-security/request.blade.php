<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Transaction Documents Request') }}
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
                <form action="{{ route('maker.request-documents.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="pb-6 space-y-6">
                        <!-- Basic Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Basic Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                <!-- Select Security -->
                                <div>
                                    <label for="security_id" class="block text-sm font-medium text-gray-700">Select
                                        Security *</label>
                                    <select name="security_id" id="security_id" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Security --</option>
                                        @foreach ($listSecurities as $security)
                                            <option value="{{ $security->id }}"
                                                {{ old('security_id') == $security->id ? 'selected' : '' }}>
                                                {{ $security->security_name }} ({{ $security->security_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Request Date -->
                                <div>
                                    <label for="request_date" class="block text-sm font-medium text-gray-700">Request
                                        Date *</label>
                                    <input type="date" name="request_date" id="request_date" required
                                        value="{{ old('request_date') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- Purpose -->
                                <div class="md:col-span-2">
                                    <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose
                                        *</label>
                                    <textarea name="purpose" id="purpose" rows="4" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('purpose') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- User Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">User Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Prepared By (Display Only) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Prepared By</label>
                                    <div
                                        class="px-4 py-2 mt-1 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                                        {{ $user->name }}
                                    </div>
                                    <!-- Hidden input to send value to backend -->
                                    <input type="hidden" name="prepared_by" value="{{ $user->name }}">
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-gray-200">
                        <a href="{{ route('list-security-m.index') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create New Security Documents Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
