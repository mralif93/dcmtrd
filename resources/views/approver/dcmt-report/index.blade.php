<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">{{ __('Choose a DCMT Report') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl px-4 mx-auto">
            @if (session('success'))
                <div class="p-4 mb-6 text-green-800 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6 sm:grid-cols-2">
                <!-- Corporate Bond Report -->
                <a href="{{ route('a.dcmt-reports.cb-reports.a') }}"
                   class="block p-4 transition bg-white border border-gray-200 rounded shadow hover:bg-gray-50">
                    <h3 class="mb-2 text-lg font-medium text-gray-900">Corporate Bond Master Report</h3>
                    <p class="text-sm text-gray-600">Financial insights and performance analysis for investment guidance.</p>
                    <div class="mt-4 text-sm font-medium text-blue-600">View Report →</div>
                </a>

                <!-- Trust Master Report -->
                <a href="{{ route('a.dcmt-reports.trustee-reports.a') }}"
                   class="block p-4 transition bg-white border border-gray-200 rounded shadow hover:bg-gray-50">
                    <h3 class="mb-2 text-lg font-medium text-gray-900">Trust Master Report</h3>
                    <p class="text-sm text-gray-600">Detailed reports with historical trends for trust management.</p>
                    <div class="mt-4 text-sm font-medium text-green-600">View Report →</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
