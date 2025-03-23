<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Activity Diary') }}
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
                <form action="{{ route('activity-diaries.update', $activityDiary) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6 pb-6">
                        <!-- Basic Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                                    <select id="issuer_id" name="issuer_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Issuer --</option>
                                        @foreach($issuers as $issuer)
                                            <option value="{{ $issuer->id }}" {{ (old('issuer_id') ?? $activityDiary->issuer_id) == $issuer->id ? 'selected' : '' }}>
                                                {{ $issuer->issuer_name }} ({{ $issuer->issuer_short_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="status" name="status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Status</option>
                                        <option value="passed" {{ (old('status') ?? $activityDiary->status) == 'passed' ? 'selected' : '' }}>Passed</option>
                                        <option value="complied" {{ (old('status') ?? $activityDiary->status) == 'complied' ? 'selected' : '' }}>Complied</option>
                                        <option value="notification" {{ (old('status') ?? $activityDiary->status) == 'notification' ? 'selected' : '' }}>Notification</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose *</label>
                                    <textarea id="purpose" name="purpose" rows="3" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('purpose') ?? $activityDiary->purpose }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dates Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Dates</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="letter_date" class="block text-sm font-medium text-gray-700">Letter Date</label>
                                    <input type="date" name="letter_date" id="letter_date" 
                                        value="{{ old('letter_date') ?? ($activityDiary->letter_date ? $activityDiary->letter_date->format('Y-m-d') : '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                                    <input type="date" name="due_date" id="due_date" 
                                        value="{{ old('due_date') ?? ($activityDiary->due_date ? $activityDiary->due_date->format('Y-m-d') : '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            
                            <!-- Extension Dates -->
                            <div class="mt-6 border-t border-gray-200 pt-4">
                                <h4 class="text-md font-medium text-gray-700 mb-4">Extension Dates (Optional)</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                    <div>
                                        <label for="extension_date_1" class="block text-sm font-medium text-gray-700">1st Extension Date</label>
                                        <input type="date" name="extension_date_1" id="extension_date_1" 
                                            value="{{ old('extension_date_1') ?? ($activityDiary->extension_date_1 ? $activityDiary->extension_date_1->format('Y-m-d') : '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="extension_note_1" class="block text-sm font-medium text-gray-700">1st Extension Note</label>
                                        <input type="text" name="extension_note_1" id="extension_note_1" 
                                            value="{{ old('extension_note_1') ?? $activityDiary->extension_note_1 ?? '(1st Extension)' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="extension_date_2" class="block text-sm font-medium text-gray-700">2nd Extension Date</label>
                                        <input type="date" name="extension_date_2" id="extension_date_2" 
                                            value="{{ old('extension_date_2') ?? ($activityDiary->extension_date_2 ? $activityDiary->extension_date_2->format('Y-m-d') : '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="extension_note_2" class="block text-sm font-medium text-gray-700">2nd Extension Note</label>
                                        <input type="text" name="extension_note_2" id="extension_note_2" 
                                            value="{{ old('extension_note_2') ?? $activityDiary->extension_note_2 ?? '(2nd Extension)' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="remarks" name="remarks" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks') ?? $activityDiary->remarks }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Verification Section -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Verification</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="verified_by" class="block text-sm font-medium text-gray-700">Verified By</label>
                                    <input type="text" name="verified_by" id="verified_by" 
                                        value="{{ old('verified_by') ?? $activityDiary->verified_by }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                                        {{ $activityDiary->created_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $activityDiary->updated_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $activityDiary->prepared_by ?? 'N/A' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('activity-diaries.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Activity Diary
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>