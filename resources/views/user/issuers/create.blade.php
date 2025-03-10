<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Issuer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            
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
                <form action="{{ route('issuers-info.store') }}" method="POST" class="p-6">
                    @csrf

                    <!-- Section: Issuer Details -->
                    <div class="pb-6 space-y-6">
                        <h3 class="pb-4 mb-4 text-lg font-bold text-gray-900 border-b">Issuer Details</h3>

                        <!-- Row 1: Full Name -->
                        <div>
                            <label for="issuer_name" class="block text-sm font-medium text-gray-700">Issuer Name *</label>
                            <input type="text" name="issuer_name" id="issuer_name" 
                                value="{{ old('issuer_name') }}" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Row 2: Short Name, Registration Number -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="issuer_short_name" class="block text-sm font-medium text-gray-700">Short Name *</label>
                                <input type="text" name="issuer_short_name" id="issuer_short_name" 
                                    value="{{ old('issuer_short_name') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="registration_number" class="block text-sm font-medium text-gray-700">Registration Number *</label>
                                <input type="text" name="registration_number" id="registration_number" 
                                    value="{{ old('registration_number') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('issuers-info.index') }}" 
                           class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Issuer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>