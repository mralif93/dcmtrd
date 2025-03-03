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

                    <!-- Filters -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <form action="{{ route('site-visits.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="property_id" class="block mb-1 text-sm font-medium text-gray-700">Property</label>
                                <select name="property_id" id="property_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All Properties</option>
                                    @foreach(\App\Models\Property::orderBy('name')->get() as $property)
                                        <option value="{{ $property->id }}" {{ request('property_id') == $property->id ? 'selected' : '' }}>
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All Statuses</option>
                                    @foreach(['scheduled', 'completed', 'cancelled', 'postponed'] as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="date_from" class="block mb-1 text-sm font-medium text-gray-700">Date From</label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            
                            <div>
                                <label for="date_to" class="block mb-1 text-sm font-medium text-gray-700">Date To</label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            
                            <div class="md:col-span-4 flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                    Apply Filters
                                </button>
                                <a href="{{ route('site-visits.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                    Reset
                                </a>
                            </div>
                        </form>
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
                                                    <a href="{{ route('site-visits.show', $visit) }}" class="px-2 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                                        View
                                                    </a>
                                                    <a href="{{ route('site-visits.edit', $visit) }}" class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded hover:bg-yellow-200">
                                                        Edit
                                                    </a>
                                                    @if($visit->hasAttachment())
                                                        <a href="{{ route('site-visits.download', $visit) }}" class="px-2 py-1 bg-green-100 text-green-600 rounded hover:bg-green-200">
                                                            Download
                                                        </a>
                                                    @endif
                                                    <form action="{{ route('site-visits.destroy', $visit) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this site visit?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200">
                                                            Delete
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