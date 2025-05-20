<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Tenancy Letter') }}
            </h2>
            <a href="{{ route('tenancy-letter-m.index', $propertyInfo) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
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

                    <form method="POST" action="{{ route('tenancy-letter-m.update', [$propertyInfo, $tenancyLetter]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Tenancy Letter Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Lease Selection -->
                                <div class="col-span-2">
                                    <label for="lease_id" class="block text-sm font-medium text-gray-500">Lease</label>
                                    <select id="lease_id" name="lease_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select a lease</option>
                                        @foreach($leases as $lease)
                                            <option value="{{ $lease->id }}" {{ old('lease_id', $tenancyLetter->lease_id) == $lease->id ? 'selected' : '' }}>
                                                {{ $lease->lease_number }} ({{ $lease->property->name ?? 'Unknown Property' }})
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
                                    <input id="our_reference" type="text" name="our_reference" value="{{ old('our_reference', $tenancyLetter->our_reference) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('our_reference')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Letter Date -->
                                <div>
                                    <label for="letter_date" class="block text-sm font-medium text-gray-500">Letter Date</label>
                                    <input id="letter_date" type="date" name="letter_date" value="{{ old('letter_date', $tenancyLetter->letter_date ? $tenancyLetter->letter_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('letter_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Recipient Information -->
                                <div class="col-span-2">
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Recipient Information</h4>
                                </div>

                                <div>
                                    <label for="recipient_company" class="block text-sm font-medium text-gray-500">Recipient Company</label>
                                    <input id="recipient_company" type="text" name="recipient_company" value="{{ old('recipient_company', $tenancyLetter->recipient_company) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('recipient_company')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="recipient_address" class="block text-sm font-medium text-gray-500">Recipient Address</label>
                                    <textarea id="recipient_address" name="recipient_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('recipient_address', $tenancyLetter->recipient_address) }}</textarea>
                                    @error('recipient_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
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

                                <!-- Internal Information -->
                                <div class="col-span-2">
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Internal Information</h4>
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
                                    <input id="approver_name" type="text" name="approver_name" value="{{ old('approver_name', $tenancyLetter->approver_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('approver_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="approver_position" class="block text-sm font-medium text-gray-500">Approver Position</label>
                                    <input id="approver_position" type="text" name="approver_position" value="{{ old('approver_position', $tenancyLetter->approver_position) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('approver_position')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="approver_department" class="block text-sm font-medium text-gray-500">Approver Department</label>
                                    <input id="approver_department" type="text" name="approver_department" value="{{ old('approver_department', $tenancyLetter->approver_department) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('approver_department')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status and Workflow -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-500">Status</label>
                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="draft" {{ old('status', $tenancyLetter->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="pending_approval" {{ old('status', $tenancyLetter->status) == 'pending_approval' ? 'selected' : '' }}>Pending Approval</option>
                                        <option value="approved" {{ old('status', $tenancyLetter->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('status', $tenancyLetter->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="prepared_by" class="block text-sm font-medium text-gray-500">Prepared By</label>
                                    <input id="prepared_by" type="text" name="prepared_by" value="{{ old('prepared_by', $tenancyLetter->prepared_by) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('prepared_by')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="verified_by" class="block text-sm font-medium text-gray-500">Verified By</label>
                                    <input id="verified_by" type="text" name="verified_by" value="{{ old('verified_by', $tenancyLetter->verified_by) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('verified_by')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Remarks -->
                                <div class="col-span-2">
                                    <label for="remarks" class="block text-sm font-medium text-gray-500">Remarks</label>
                                    <textarea id="remarks" name="remarks" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks', $tenancyLetter->remarks) }}</textarea>
                                    @error('remarks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Current Attachment -->
                                @if($tenancyLetter->attachment)
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-500">Current Attachment</label>
                                    <div class="mt-1 flex items-center">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <span class="ml-2 text-sm text-gray-500">{{ basename($tenancyLetter->attachment) }}</span>
                                        <a href="{{ asset('storage/' . $tenancyLetter->attachment) }}" target="_blank" class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">
                                            View
                                        </a>
                                    </div>
                                </div>
                                @endif

                                <!-- New Attachment -->
                                <div class="col-span-2">
                                    <label for="attachment" class="block text-sm font-medium text-gray-500">{{ $tenancyLetter->attachment ? 'Replace Attachment' : 'Attachment' }}</label>
                                    <input id="attachment" type="file" name="attachment" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-6 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="mt-1 text-sm text-gray-500">Accepted formats: PDF, DOC, DOCX (max 10MB)</p>
                                    @error('attachment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('tenancy-letter-m.index', $propertyInfo) }}" 
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