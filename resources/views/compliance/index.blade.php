<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800">
            {{ __('Compliance Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                <!-- Card 1 -->
                <a href="{{ route('compliance.cb-reports.batches') }}"
                    class="block p-6 transition-all duration-200 bg-white border border-gray-200 shadow rounded-xl hover:shadow-lg">
                    <h3 class="text-lg font-semibold text-indigo-700">CB Master Report</h3>
                    <p class="mt-2 text-sm text-gray-600">View and manage trustee master data and batch reports.</p>
                </a>

                <!-- Card 1 -->
                <a
                    class="block p-6 transition-all duration-200 bg-white border border-gray-200 shadow rounded-xl hover:shadow-lg">
                    <h3 class="text-lg font-semibold text-indigo-700">Trustee Master Report</h3>
                    <p class="mt-2 text-sm text-gray-600">View and manage trustee master data and batch reports.</p>
                </a>

                <!-- Card 2 -->
                <a
                    class="block p-6 transition-all duration-200 bg-white border border-gray-200 shadow rounded-xl hover:shadow-lg">
                    <h3 class="text-lg font-semibold text-indigo-700">Audit Logs</h3>
                    <p class="mt-2 text-sm text-gray-600">Review all user activity and system audit trails.</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
