<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Tenancy Letter') }}
            </h2>
            <a href="{{ route('tenancy-letter-m.show', $tenancyLetter) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
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

                    <form method="POST" action="{{ route('tenancy-letter-m.update', $tenancyLetter) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Tenancy Letter Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Lease Selection -->
                                <div class="hidden">
                                    <label for="lease_id" class="block text-sm font-medium text-gray-500">Lease</label>
                                    <select id="lease_id" name="lease_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select a lease</option>
                                        @foreach($leases as $lease)
                                            <option value="{{ $lease->id }}" {{ old('lease_id', $tenancyLetter->lease_id) == $lease->id ? 'selected' : '' }}>
                                                {{ $lease->lease_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('lease_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- References -->
                                <div>
                                    <label for="your_reference" class="block text-sm font-medium text-gray-500">Your Reference</label>
                                    <input id="your_reference" type="text" name="your_reference" value="{{ old('your_reference', $tenancyLetter->your_reference) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('your_reference')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="our_reference" class="block text-sm font-medium text-gray-500">Our Reference</label>
                                    <input id="our_reference" type="text" name="our_reference" value="{{ old('our_reference', $tenancyLetter->our_reference) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('our_reference')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Letter Date -->
                                <div>
                                    <label for="letter_date" class="block text-sm font-medium text-gray-500">Letter Date</label>
                                    <input id="letter_date" type="date" name="letter_date" value="{{ old('letter_date', $tenancyLetter->letter_date ? $tenancyLetter->letter_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('letter_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Recipient Information -->
                                <div class="col-span-2">
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Recipient Information</h4>
                                </div>

                                <div class="col-span-2">
                                    <label for="recipient_company" class="block text-sm font-medium text-gray-500">Recipient Company</label>
                                    <input id="recipient_company" type="text" name="recipient_company" value="{{ old('recipient_company', $tenancyLetter->recipient_company) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('recipient_company')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address Lines -->
                                <div class="col-span-2">
                                    <label for="recipient_address_line_1" class="block text-sm font-medium text-gray-500">Address Line 1</label>
                                    <input id="recipient_address_line_1" type="text" name="recipient_address_line_1" value="{{ old('recipient_address_line_1', $tenancyLetter->recipient_address_line_1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('recipient_address_line_1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="recipient_address_line_2" class="block text-sm font-medium text-gray-500">Address Line 2</label>
                                    <input id="recipient_address_line_2" type="text" name="recipient_address_line_2" value="{{ old('recipient_address_line_2', $tenancyLetter->recipient_address_line_2) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('recipient_address_line_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="recipient_address_line_3" class="block text-sm font-medium text-gray-500">Address Line 3</label>
                                    <input id="recipient_address_line_3" type="text" name="recipient_address_line_3" value="{{ old('recipient_address_line_3', $tenancyLetter->recipient_address_line_3) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('recipient_address_line_3')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="recipient_address_postcode" class="block text-sm font-medium text-gray-500">Postcode</label>
                                    <input id="recipient_address_postcode" type="text" name="recipient_address_postcode" value="{{ old('recipient_address_postcode', $tenancyLetter->recipient_address_postcode) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('recipient_address_postcode')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="recipient_address_city" class="block text-sm font-medium text-gray-500">City</label>
                                    <input id="recipient_address_city" type="text" name="recipient_address_city" value="{{ old('recipient_address_city', $tenancyLetter->recipient_address_city) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('recipient_address_city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="recipient_address_state" class="block text-sm font-medium text-gray-500">State</label>
                                    <input id="recipient_address_state" type="text" name="recipient_address_state" value="{{ old('recipient_address_state', $tenancyLetter->recipient_address_state) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('recipient_address_state')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="recipient_address_country" class="block text-sm font-medium text-gray-500">Country</label>
                                    <input id="recipient_address_country" type="text" name="recipient_address_country" value="{{ old('recipient_address_country', $tenancyLetter->recipient_address_country) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('recipient_address_country')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Attention Information -->
                                <div class="col-span-2">
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Attention Information</h4>
                                </div>

                                <div>
                                    <label for="attention_to_name" class="block text-sm font-medium text-gray-500">Attention To (Name)</label>
                                    <input id="attention_to_name" type="text" name="attention_to_name" value="{{ old('attention_to_name', $tenancyLetter->attention_to_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('attention_to_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="attention_to_position" class="block text-sm font-medium text-gray-500">Attention To (Position)</label>
                                    <input id="attention_to_position" type="text" name="attention_to_position" value="{{ old('attention_to_position', $tenancyLetter->attention_to_position) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('attention_to_position')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Letter Content -->
                                <div class="col-span-2">
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Letter Content</h4>
                                </div>

                                <!-- Letter Offer Date -->
                                <div>
                                    <label for="letter_offer_date" class="block text-sm font-medium text-gray-500">Letter Offer Date</label>
                                    <input id="letter_offer_date" type="date" name="letter_offer_date" value="{{ old('letter_offer_date', $tenancyLetter->letter_offer_date ? $tenancyLetter->letter_offer_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('letter_offer_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="description_1" class="block text-sm font-medium text-gray-500">Description 1</label>
                                    <textarea id="description_1" name="description_1" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description_1', $tenancyLetter->description_1) }}</textarea>
                                    @error('description_1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="description_2" class="block text-sm font-medium text-gray-500">Description 2</label>
                                    <textarea id="description_2" name="description_2" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description_2', $tenancyLetter->description_2) }}</textarea>
                                    @error('description_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="description_3" class="block text-sm font-medium text-gray-500">Description 3</label>
                                    <textarea id="description_3" name="description_3" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description_3', $tenancyLetter->description_3) }}</textarea>
                                    @error('description_3')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Signature Information -->
                                <div class="col-span-2">
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Signature Information</h4>
                                </div>

                                <div>
                                    <label for="trustee_name" class="block text-sm font-medium text-gray-500">Trustee Name</label>
                                    <input id="trustee_name" type="text" name="trustee_name" value="{{ old('trustee_name', $tenancyLetter->trustee_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="approver_name" class="block text-sm font-medium text-gray-500">Approver Name</label>
                                    <input id="approver_name" type="text" name="approver_name" value="{{ old('approver_name', $tenancyLetter->approver_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('approver_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="approver_position" class="block text-sm font-medium text-gray-500">Approver Position</label>
                                    <input id="approver_position" type="text" name="approver_position" value="{{ old('approver_position', $tenancyLetter->approver_position) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('approver_position')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="approver_department" class="block text-sm font-medium text-gray-500">Approver Department</label>
                                    <input id="approver_department" type="text" name="approver_department" value="{{ old('approver_department', $tenancyLetter->approver_department) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('approver_department')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('tenancy-letter-m.show', $tenancyLetter) }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Update Tenancy Letter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>