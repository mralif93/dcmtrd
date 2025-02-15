<x-guest-layout>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Two-Factor Authentication</h1>
        <p class="text-lg text-gray-600 text-center mb-6">Enter the code sent to your email:</p>

        @if ($errors->any())
            <div class="mb-4">
                <div class="bg-red-100 border border-red-400 text-red-600 p-4 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('two-factor.verify') }}" method="POST" class="mx-auto w-full max-w-sm">
            @csrf
            <div class="mb-4 flex flex-col items-center">
                <label for="code" class="block text-sm font-medium text-gray-700 text-center">Verification Code</label>
                <input type="text" name="code" id="code" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-center" placeholder="Enter your code">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Verify
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>