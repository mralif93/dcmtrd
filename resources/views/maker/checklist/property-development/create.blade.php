<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Property Development') }}
            </h2>
            <a href="{{ route('checklist-m.show', $checklist) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
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

                    <form method="POST" action="{{ route('checklist-property-development-m.store') }}">
                        @csrf
                        <input type="hidden" name="checklist_id" value="{{ $checklist->id }}">

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Property Development Information</h3>
                            </div>

                            <!-- Development/Expansion Section -->
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h4 class="font-medium text-gray-700 mb-3">Development/Expansion</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Development Date -->
                                    <div>
                                        <label for="development_date" class="block text-sm font-medium text-gray-500">Date</label>
                                        <input id="development_date" type="date" name="development_date" value="{{ old('development_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('development_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Development Status -->
                                    <div>
                                        <label for="development_status" class="block text-sm font-medium text-gray-500">Status</label>
                                        <select id="development_status" name="development_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select status</option>
                                            <option value="pending" {{ old('development_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ old('development_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ old('development_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        @error('development_status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Development Scope of Work -->
                                    <div class="md:col-span-3">
                                        <label for="development_scope_of_work" class="block text-sm font-medium text-gray-500">Scope of Work</label>
                                        <textarea id="development_scope_of_work" name="development_scope_of_work" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('development_scope_of_work') }}</textarea>
                                        @error('development_scope_of_work')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Renovation Section -->
                            <div class="border rounded-lg p-4 bg-white">
                                <h4 class="font-medium text-gray-700 mb-3">Renovation</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Renovation Date -->
                                    <div>
                                        <label for="renovation_date" class="block text-sm font-medium text-gray-500">Date</label>
                                        <input id="renovation_date" type="date" name="renovation_date" value="{{ old('renovation_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('renovation_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Renovation Status -->
                                    <div>
                                        <label for="renovation_status" class="block text-sm font-medium text-gray-500">Status</label>
                                        <select id="renovation_status" name="renovation_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select status</option>
                                            <option value="pending" {{ old('renovation_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ old('renovation_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ old('renovation_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        @error('renovation_status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Renovation Scope of Work -->
                                    <div class="md:col-span-3">
                                        <label for="renovation_scope_of_work" class="block text-sm font-medium text-gray-500">Scope of Work</label>
                                        <textarea id="renovation_scope_of_work" name="renovation_scope_of_work" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('renovation_scope_of_work') }}</textarea>
                                        @error('renovation_scope_of_work')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- External Repainting Section -->
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h4 class="font-medium text-gray-700 mb-3">External Repainting</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- External Repainting Date -->
                                    <div>
                                        <label for="external_repainting_date" class="block text-sm font-medium text-gray-500">Date</label>
                                        <input id="external_repainting_date" type="date" name="external_repainting_date" value="{{ old('external_repainting_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('external_repainting_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- External Repainting Status -->
                                    <div>
                                        <label for="external_repainting_status" class="block text-sm font-medium text-gray-500">Status</label>
                                        <select id="external_repainting_status" name="external_repainting_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select status</option>
                                            <option value="pending" {{ old('external_repainting_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ old('external_repainting_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ old('external_repainting_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        @error('external_repainting_status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- External Repainting Scope of Work -->
                                    <div class="md:col-span-3">
                                        <label for="external_repainting_scope_of_work" class="block text-sm font-medium text-gray-500">Scope of Work</label>
                                        <textarea id="external_repainting_scope_of_work" name="external_repainting_scope_of_work" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('external_repainting_scope_of_work') }}</textarea>
                                        @error('external_repainting_scope_of_work')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Others/Proposals/Approvals Section -->
                            <div class="border rounded-lg p-4 bg-white">
                                <h4 class="font-medium text-gray-700 mb-3">Others/Proposals/Approvals</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Others/Proposals/Approvals Date -->
                                    <div>
                                        <label for="others_proposals_approvals_date" class="block text-sm font-medium text-gray-500">Date</label>
                                        <input id="others_proposals_approvals_date" type="date" name="others_proposals_approvals_date" value="{{ old('others_proposals_approvals_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('others_proposals_approvals_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Others/Proposals/Approvals Status -->
                                    <div>
                                        <label for="others_proposals_approvals_status" class="block text-sm font-medium text-gray-500">Status</label>
                                        <select id="others_proposals_approvals_status" name="others_proposals_approvals_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select status</option>
                                            <option value="pending" {{ old('others_proposals_approvals_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ old('others_proposals_approvals_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ old('others_proposals_approvals_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        @error('others_proposals_approvals_status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Others/Proposals/Approvals Scope of Work -->
                                    <div class="md:col-span-3">
                                        <label for="others_proposals_approvals_scope_of_work" class="block text-sm font-medium text-gray-500">Scope of Work</label>
                                        <textarea id="others_proposals_approvals_scope_of_work" name="others_proposals_approvals_scope_of_work" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('others_proposals_approvals_scope_of_work') }}</textarea>
                                        @error('others_proposals_approvals_scope_of_work')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- System Information -->
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h4 class="font-medium text-gray-700 mb-3">System Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Overall Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-500">Overall Status</label>
                                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select status</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        @error('status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Prepared By -->
                                    <div>
                                        <label for="prepared_by" class="block text-sm font-medium text-gray-500">Prepared By</label>
                                        <input id="prepared_by" type="text" name="prepared_by" value="{{ old('prepared_by', Auth::user()->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('prepared_by')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Verified By -->
                                    <div>
                                        <label for="verified_by" class="block text-sm font-medium text-gray-500">Verified By</label>
                                        <input id="verified_by" type="text" name="verified_by" value="{{ old('verified_by') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('verified_by')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Approval DateTime -->
                                    <div>
                                        <label for="approval_datetime" class="block text-sm font-medium text-gray-500">Approval Date & Time</label>
                                        <input id="approval_datetime" type="datetime-local" name="approval_datetime" value="{{ old('approval_datetime') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('approval_datetime')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Remarks -->
                                    <div class="md:col-span-2">
                                        <label for="remarks" class="block text-sm font-medium text-gray-500">Remarks</label>
                                        <textarea id="remarks" name="remarks" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks') }}</textarea>
                                        @error('remarks')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('checklist-m.show', $checklist) }}" 
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
                                    Create Property Development
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>