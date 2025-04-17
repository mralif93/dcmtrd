<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-semibold text-gray-800">{{ __('Choose a DCMT Report') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-500 rounded-md shadow-md bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Corporate Bond Master Report -->
                <a href="{{ route('dcmt-reports.cb-reports') }}" class="flex flex-col p-6 transition-all duration-300 transform shadow-xl bg-gradient-to-r from-blue-200 to-blue-300 rounded-xl hover:scale-105 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <div class="p-4 text-blue-600 bg-white rounded-full shadow-md">
                            <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 11.5a8.38 8.38 0 01-.9 3.8A8.5 8.5 0 112.1 9.7a8.38 8.38 0 013.8-.9A5 5 0 0121 11.5z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800">Corporate Bond Master Report</h3>
                    </div>
                    <p class="mt-4 text-sm text-gray-700">In-depth financial insights and performance analysis to guide investment decisions.</p>
                    <div class="flex items-center justify-between mt-6">
                        <span class="text-sm text-gray-600">View Report</span>
                        <span class="text-lg font-semibold text-blue-600">→</span>
                    </div>
                </a>

                <!-- Trust Master Report -->
                <a href="{{ route('dcmt-reports.trustee-reports') }}" class="flex flex-col p-6 transition-all duration-300 transform shadow-xl bg-gradient-to-r from-green-200 to-green-300 rounded-xl hover:scale-105 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <div class="p-4 text-green-600 bg-white rounded-full shadow-md">
                            <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2a10 10 0 00-7 17l-1 3 3-1a10 10 0 1011-19zm-1 15h-2v-6h2zm4 0h-2v-6h2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800">Trust Master Report</h3>
                    </div>
                    <p class="mt-4 text-sm text-gray-700">Comprehensive reporting with historical trends to help optimize trust management.</p>
                    <div class="flex items-center justify-between mt-6">
                        <span class="text-sm text-gray-600">View Report</span>
                        <span class="text-lg font-semibold text-green-600">→</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
