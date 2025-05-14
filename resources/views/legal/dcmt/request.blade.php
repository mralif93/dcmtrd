<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-start gap-2">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                ← Back
            </a>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Create New Security Document Request') }}
            </h2>
        </div>

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
                <form action="{{ route('legal.request-documents.store', $getListSec->id) }}" method="POST"
                    class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Issuer Dropdown -->
                        <div>
                            <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer</label>
                            <select name="issuer_id" id="issuer_id" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                disabled>
                                <option value="{{ $getListSec->issuer->id }}" selected>
                                    {{ $getListSec->issuer->issuer_short_name }} -
                                    {{ $getListSec->issuer->issuer_name }}
                                </option>
                            </select>
                        </div>

                        <!-- Security Name -->
                        <div>
                            <label for="security_name" class="block text-sm font-medium text-gray-700">Security Name
                            </label>
                            <input type="text" name="security_name" id="security_name" required
                                value="{{ old('security_name', $getListSec->security_name) }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                disabled>
                        </div>

                        <!-- List Security ID (hidden) -->
                        <input type="hidden" name="list_security_id" value="{{ $getListSec->id }}">


                        <!-- Security Code -->
                        <div>
                            <label for="security_code" class="block text-sm font-medium text-gray-700">Security Code
                            </label>
                            <input type="text" name="security_code" id="security_code" required
                                value="{{ old('security_code', $getListSec->security_code) }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                disabled>
                        </div>

                        <div>
                            <label for="asset_name_type" class="block text-sm font-medium text-gray-700">Asset Name Type
                            </label>
                            <select name="asset_name_type" id="asset_name_type" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                disabled>
                                <option value="{{ $getListSec->asset_name_type }}" selected>
                                    {{ $getListSec->asset_name_type }}
                                </option>
                            </select>
                        </div>

                    </div>

                    <!-- Additional Fields -->
                    <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2">
                        <!-- Purpose -->
                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose *</label>
                            <textarea name="purpose" id="purpose" required rows="4"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('purpose') }}</textarea>
                        </div>

                        <!-- Date Requested -->
                        <div>
                            <label for="request_date" class="block text-sm font-medium text-gray-700">Request Date
                                *</label>
                            <input type="date" name="request_date" id="request_date" required
                                value="{{ old('request_date', now()->toDateString()) }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('list-security-m.index') }}"
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
