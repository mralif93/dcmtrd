<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800">
            {{ __('📊 Choose a DCMT Report') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl px-4 mx-auto">
            @if (session('success'))
                <div class="p-4 mb-6 text-green-900 bg-green-100 border-l-4 border-green-400 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6 sm:grid-cols-2">
                <!-- Corporate Bond Report -->
                <a href="{{ route('a.dcmt-reports.cb-reports.a') }}"
                    class="block p-6 transition-all duration-300 bg-white border border-gray-200 shadow group rounded-xl hover:shadow-md hover:border-blue-400">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">
                            Corporate Bond Master Report
                        </h3>
                        <svg class="w-5 h-5 text-blue-500 transition transform group-hover:translate-x-1" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">
                        Financial insights and performance analysis for investment guidance.
                    </p>
                    <div class="mt-4 text-sm font-medium text-blue-600">View Report</div>
                </a>

                <!-- Trust Master Report -->
                <a href="{{ route('a.dcmt-reports.trustee-reports.a') }}"
                    class="block p-6 transition-all duration-300 bg-white border border-gray-200 shadow group rounded-xl hover:shadow-md hover:border-green-400">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-green-700">
                            Trust Master Report
                        </h3>
                        <svg class="w-5 h-5 text-green-500 transition transform group-hover:translate-x-1"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">
                        Detailed reports with historical trends for trust management.
                    </p>
                    <div class="mt-4 text-sm font-medium text-green-600">View Report</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
