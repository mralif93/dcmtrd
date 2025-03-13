<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Upload Rating Movement') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex justify-center py-12">
        <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg">
            <h3 class="mb-6 text-lg font-semibold text-center text-gray-700">
                Upload a New Rating Movement
            </h3>

            @if(session('success'))
                <div class="p-4 mb-4 text-center text-green-700 bg-green-100 border border-green-400 rounded">
                    {{ session('success') }}  
                    <br>
                </div>
            @endif

            <!-- Display All Errors -->
            @if ($errors->any())
                <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rating-movements-info.upload-store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- File Input -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Choose Rating Movement File</label>
                    <input type="file" name="rating_movement_file" class="w-full p-2 border rounded" required>
                </div>
                
                <!-- Upload Button -->
                <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
                    Upload Rating Movement
                </button>

            </form>
        </div>
    </div>
</x-app-layout>