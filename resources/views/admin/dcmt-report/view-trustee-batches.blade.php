<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800">{{ __('Trust Master Reports') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('dcmt-reports.trustee-reports') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m9 7h-6"></path>
                    </svg>
                    Back
                </a>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-500 rounded-md shadow bg-green-50">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="p-4 mb-6 border-l-4 border-red-500 rounded-md shadow bg-red-50">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Data Table --}}
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="min-w-full text-sm divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold text-left text-gray-600 uppercase">Title Report</th>
                                <th class="px-6 py-3 font-semibold text-left text-gray-600 uppercase">Cut-Off Date</th>
                                <th class="px-6 py-3 font-semibold text-left text-gray-600 uppercase">Prepared By</th>
                                <th class="px-6 py-3 font-semibold text-left text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($batches as $batch)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $batch->title_report }}</td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ \Carbon\Carbon::parse($batch->cut_off_at)->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $batch->creator->name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-3">
                                            {{-- Download Button --}}
                                            <a href="{{ route('dcmt-reports.trustee-reports.download', $batch->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-600 hover:text-green-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                                </svg>
                                                Download
                                            </a>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('dcmt-reports.cb-reports.delete', $batch->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this batch?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 hover:text-red-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M6 2L6 6M6 6L18 6M18 6L18 2M18 2L6 2M12 6v12M12 18H6M12 18h6" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No batches available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3 bg-white border-t border-gray-200">
                    {{ $batches->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
