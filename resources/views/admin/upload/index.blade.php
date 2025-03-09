<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('File Upload') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                <div class="p-8">
                    <h3 class="text-2xl font-semibold text-gray-700">Upload a File</h3>
                    <p class="text-gray-500">Select a file to upload. Allowed formats: JPG, PNG, PDF, DOCX (Max: 2MB).</p>

                    @if(session('success'))
                        <div class="p-4 mt-6 text-green-800 bg-green-100 border border-green-400 rounded-lg">
                            <span class="font-semibold">Success:</span> {{ session('success') }}  
                            <br>
                            <a href="{{ asset('storage/' . session('path')) }}" class="text-blue-600 hover:underline" target="_blank">View File</a>
                        </div>
                    @endif

                    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <label class="block font-medium text-gray-700">Choose a file</label>
                            <div class="flex items-center justify-center w-full p-4 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="file" name="file" class="w-full" required>
                            </div>
                            @error('file')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-300">
                            Upload File
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
