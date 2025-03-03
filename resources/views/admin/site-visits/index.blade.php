<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Site Visits') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-semibold">Manage Site Visits</h3>
                        <a href="{{ route('site-visits.create') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                            Add New Site Visit
                        </a>
                    </div>

                    <!-- Site Visits Table -->
                    @if($siteVisits->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left">Property</th>
                                        <th class="px-4 py-2 text-left">Visit Date</th>
                                        <th class="px-4 py-2 text-left">Inspector</th>
                                        <th class="px-4 py-2 text-center">Status</th>
                                        <th class="px-4 py-2 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siteVisits as $visit)
                                        <tr class="border-t hover:bg-gray-50">
                                            <td class="px-4 py-3">{{ $visit->property->name }}</td>
                                            <td class="px-4 py-3">{{ $visit->date_site_visit->format('M d, Y') }}</td>
                                            <td class="px-4 py-3">{{ $visit->inspector_name ?? 'Not Assigned' }}</td>
                                            <td class="px-4 py-3 text-center">{!! $visit->status_badge !!}</td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('site-visits.show', $visit) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('site-visits.edit', $visit) }}" class="text-yellow-600 hover:text-yellow-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    @if($visit->hasAttachment())
                                                        <a href="{{ route('site-visits.download', $visit) }}" class="text-blue-600 hover:text-blue-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 4v12m0 0l-3-3m3 3l3-3"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    <form action="{{ route('site-visits.destroy', $visit) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this site visit?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $siteVisits->links() }}
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-md text-center">
                            No site visits found. <a href="{{ route('site-visits.create') }}" class="text-blue-500 hover:underline">Create your first site visit</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>