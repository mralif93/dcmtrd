<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New User') }}
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
                <form action="{{ route('users.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-6 pb-6">
                        <!-- Row 1: Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                            <input type="text" name="name" id="name" 
                                value="{{ old('name') }}" required autocomplete="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Row 2: Email & Role -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                                <input type="email" name="email" id="email" 
                                    value="{{ old('email') }}" required autocomplete="email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role *</label>
                                <select name="role" id="role" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Role</option>
                                    <option value="admin" @selected(old('role') == 'admin')>Administrator</option>
                                    <option value="user" @selected(old('role') == 'user')>User</option>
                                    <option value="maker" @selected(old('role') == 'maker')>Maker</option>
                                    <option value="approver" @selected(old('role') == 'approver')>Approver</option>
                                    <option value="legal" @selected(old('role') == 'legal')>Legal</option>
                                    <option value="compliance" @selected(old('role') == 'compliance')>Compliance</option>
                                </select>
                            </div>
                            <div>
                                <label for="job_title" class="block text-sm font-medium text-gray-700">Job Title *</label>
                                <select name="job_title" id="job_title" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Job Title</option>
                                    <option value="CEO" @selected(old('job_title') == 'CEO')>CEO</option>
                                    <option value="SENIOR MANAGER" @selected(old('job_title') == 'SENIOR MANAGER')>SENIOR MANAGER</option>
                                    <option value="MANAGER" @selected(old('job_title') == 'MANAGER')>MANAGER</option>
                                    <option value="ASSISTANT MANAGER" @selected(old('job_title') == 'ASSISTANT MANAGER')>ASSISTANT MANAGER</option>
                                    <option value="SENIOR EXECUTIVE" @selected(old('job_title') == 'SENIOR EXECUTIVE')>SENIOR EXECUTIVE</option>
                                    <option value="EXECUTIVE" @selected(old('job_title') == 'EXECUTIVE')>EXECUTIVE</option>
                                    <option value="DEVELOPER" @selected(old('job_title') == 'DEVELOPER')>DEVELOPER</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Permission *</label>
                                <div class="flex flex-wrap gap-6">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_dcmtrd" value="dcmtrd" 
                                            {{ is_array(old('permissions')) && in_array('dcmtrd', old('permissions')) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="permission_dcmtrd" class="ml-2 block text-sm text-gray-900">DCMTRD</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_reits" value="reits"
                                            {{ is_array(old('permissions')) && in_array('reits', old('permissions')) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="permission_reits" class="ml-2 block text-sm text-gray-900">REITS</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_legal" value="legal"
                                            {{ is_array(old('permissions')) && in_array('legal', old('permissions')) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="permission_legal" class="ml-2 block text-sm text-gray-900">LEGAL</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_compliance" value="compliance"
                                            {{ is_array(old('permissions')) && in_array('compliance', old('permissions')) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="permission_compliance" class="ml-2 block text-sm text-gray-900">COMPLIANCE</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_smd" value="smd"
                                            {{ is_array(old('permissions')) && in_array('smd', old('permissions')) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="permission_smd" class="ml-2 block text-sm text-gray-900">SMD</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Department & Office Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700">Department *</label>
                                <input type="text" name="department" id="department" 
                                    value="{{ old('department') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="office_location" class="block text-sm font-medium text-gray-700">Office Location</label>
                                <input type="text" name="office_location" id="office_location" 
                                    value="{{ old('office_location') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 4: Password & Confirm Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                                <input type="password" name="password" id="password" required
                                    autocomplete="new-password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Security Settings</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input type="checkbox" name="two_factor_enabled" id="two_factor_enabled" 
                                            value="1" @checked(old('two_factor_enabled'))
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="two_factor_enabled" class="font-medium text-gray-700">Enable Two-Factor Authentication</label>
                                        <p class="text-gray-500">Require 2FA for this user account</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('users.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>