<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
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
                <form action="{{ route('users.update', $user) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="pb-6 space-y-6">
                        <!-- Row 1: Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                            <input type="text" name="name" id="name" 
                                value="{{ old('name', $user->name) }}" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Row 2: Email & Role -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                                <input type="email" name="email" id="email" 
                                    value="{{ old('email', $user->email) }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role *</label>
                                <select name="role" id="role" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Role</option>
                                    <option value="admin" @selected(old('role', $user->role) == 'admin')>Administrator</option>
                                    <option value="user" @selected(old('role', $user->role) == 'user')>User</option>
                                    <option value="maker" @selected(old('role', $user->role) == 'maker')>Maker</option>
                                    <option value="approver" @selected(old('role', $user->role) == 'approver')>Approver</option>
                                    <option value="legal" @selected(old('role', $user->role) == 'legal')>Legal</option>
                                    <option value="compliance" @selected(old('role', $user->role) == 'compliance')>Compliance</option>
                                </select>
                            </div>
                            <div>
                                <label for="job_title" class="block text-sm font-medium text-gray-700">Job Title *</label>
                                <select name="job_title" id="job_title" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Job Title</option>
                                    <option value="ceo" @selected(old('job_title', $user->job_title) == 'ceo')>CEO</option>
                                    <option value="manager" @selected(old('job_title', $user->job_title) == 'manager')>Manager</option>
                                    <option value="executive" @selected(old('job_title', $user->job_title) == 'executive')>Executive</option>
                                    <option value="developer" @selected(old('job_title', $user->job_title) == 'developer')>Developer</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Permission *</label>
                                @php
                                    $userPermissions = $user->getPermissionsArray();
                                @endphp
                                <div class="flex space-x-6">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_dcmtrd" value="dcmtrd" 
                                            @checked(is_array(old('permissions')) ? in_array('dcmtrd', old('permissions')) : in_array('dcmtrd', $userPermissions))
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="permission_dcmtrd" class="block ml-2 text-sm text-gray-900">DCMTRD</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_reits" value="reits"
                                            @checked(is_array(old('permissions')) ? in_array('reits', old('permissions')) : in_array('reits', $userPermissions))
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="permission_reits" class="block ml-2 text-sm text-gray-900">REITS</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_legal" value="legal" 
                                            @checked(is_array(old('permissions')) ? in_array('legal', old('permissions')) : in_array('legal', $userPermissions))
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="permission_legal" class="block ml-2 text-sm text-gray-900">LEGAL</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_compliance" value="compliance"
                                            @checked(is_array(old('permissions')) ? in_array('compliance', old('permissions')) : in_array('compliance', $userPermissions))
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="permission_compliance" class="block ml-2 text-sm text-gray-900">COMPLIANCE</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Department & Office Location -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700">Department *</label>
                                <input type="text" name="department" id="department" 
                                    value="{{ old('department', $user->department) }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="office_location" class="block text-sm font-medium text-gray-700">Office Location</label>
                                <input type="text" name="office_location" id="office_location" 
                                    value="{{ old('office_location', $user->office_location) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 4: Password & Confirm Password -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="password" id="password"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Security Settings -->
                        <div class="pt-6 border-t border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Security Settings</h3>
                            
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="two_factor_enabled" id="two_factor_enabled" 
                                            value="1" @checked(old('two_factor_enabled', $user->two_factor_enabled))
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="two_factor_enabled" class="font-medium text-gray-700">Enable Two-Factor Authentication</label>
                                        <p class="text-gray-500">Require 2FA for this user account</p>
                                    </div>
                                </div>
                                
                                @if($user->two_factor_enabled)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">2FA Status</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        @if($user->two_factor_verified)
                                            <span class="px-2 py-1 text-green-800 bg-green-100 rounded-full">Verified</span>
                                        @else
                                            <span class="px-2 py-1 text-yellow-800 bg-yellow-100 rounded-full">Pending Verification</span>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- System Information -->
                        <div class="pt-6 border-t border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">System Information</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $user->created_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $user->updated_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('users.index') }}" 
                           class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>