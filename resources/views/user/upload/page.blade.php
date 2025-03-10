<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">
                {{ __('Upload Documents') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="grid max-w-6xl grid-cols-1 gap-6 mx-auto sm:grid-cols-2 md:grid-cols-3">
            
            <!-- Bond+Sukuk Upload Card -->
            <a href="{{ route('upload.bond') }}" class="block p-6 transition-all duration-300 bg-white border border-gray-200 shadow-lg group rounded-xl hover:shadow-2xl hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600">Bond+Sukuk Information</h3>
                        <p class="text-sm text-gray-500">Upload bond-related documents.</p>
                    </div>
                </div>
            </a>

            <!-- Rating Movements Upload Card -->
            <a href="{{ route('upload.rating-movement') }}" class="block p-6 transition-all duration-300 bg-white border border-gray-200 shadow-lg group rounded-xl hover:shadow-2xl hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-600">Rating Movements</h3>
                        <p class="text-sm text-gray-500">Upload rating movement reports.</p>
                    </div>
                </div>
            </a>

            <!-- Payment Schedule Upload Card -->
            <a href="{{ route('upload.payment-schedule') }}" class="block p-6 transition-all duration-300 bg-white border border-gray-200 shadow-lg group rounded-xl hover:shadow-2xl hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m4 18V3m4 18V3" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-yellow-600">Payment Schedule</h3>
                        <p class="text-sm text-gray-500">Upload payment schedule details.</p>
                    </div>
                </div>
            </a>

            <!-- Trading Activity Upload Card -->
            <a href="{{ route('upload.trading-activity') }}" class="block p-6 transition-all duration-300 bg-white border border-gray-200 shadow-lg group rounded-xl hover:shadow-2xl hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l4-4 4 4m0-8l-4 4-4-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-red-600">Trading Activity</h3>
                        <p class="text-sm text-gray-500">Upload trading activity records.</p>
                    </div>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>
