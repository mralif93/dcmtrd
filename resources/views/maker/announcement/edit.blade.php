<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Announcement') }}
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
                <form action="{{ route('announcement-m.update', $announcement) }}" method="POST" class="p-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="pb-6 space-y-6">
                        <!-- Basic Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Basic Information</h3>
                            <div>
                                <label for="facility_id" class="block text-sm font-medium text-gray-700">Facility *</label>
                                <select name="facility_id" id="facility_id" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Select Facility --</option>
                                    @foreach($facilities as $facility)
                                        <option value="{{ $facility->id }}" @selected(old('facility_id', $announcement->facility_id) == $facility->id)>
                                            {{ $facility->facility_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('facility_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Category Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Category Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                                    <input type="text" name="category" id="category" 
                                        value="{{ old('category', $announcement->category) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="sub_category" class="block text-sm font-medium text-gray-700">Sub Category</label>
                                    <input type="text" name="sub_category" id="sub_category" 
                                        value="{{ old('sub_category', $announcement->sub_category) }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('sub_category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Publication Details Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Publication Details</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="source" class="block text-sm font-medium text-gray-700">Source *</label>
                                    <input type="text" name="source" id="source" 
                                        value="{{ old('source', $announcement->source) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('source')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="announcement_date" class="block text-sm font-medium text-gray-700">Date *</label>
                                    <input type="date" name="announcement_date" id="announcement_date" 
                                        value="{{ old('announcement_date', $announcement->announcement_date->format('Y-m-d')) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('announcement_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Announcement Content</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                                    <input type="text" name="title" id="title" 
                                        value="{{ old('title', $announcement->title) }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                                    <textarea name="description" id="description" required
                                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                          rows="3">{{ old('description', $announcement->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700">Content *</label>
                                    <textarea name="content" id="content" required
                                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                          rows="6">{{ old('content', $announcement->content) }}</textarea>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Attachment Section -->
                        <div>
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Attachment</h3>
                            <div>
                                <label for="attachment" class="block text-sm font-medium text-gray-700">Upload File</label>
                                <input type="file" name="attachment" id="attachment"
                                       class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                @if($announcement->attachment)
                                    <p class="mt-2 text-sm text-gray-500">
                                        Current Attachment: 
                                        <a href="{{ Storage::url($announcement->attachment) }}" class="text-blue-600 underline" target="_blank">View</a>
                                    </p>
                                @endif
                                @error('attachment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- System Information -->
                        <div class="pt-6 border-t border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">System Information</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $announcement->created_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $announcement->updated_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('facility-info-m.show', $announcement->facility) }}" 
                           class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Announcement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>