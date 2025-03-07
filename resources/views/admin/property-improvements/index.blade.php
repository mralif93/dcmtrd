<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Property Improvements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">All Property Improvements</h3>
                        <a href="{{ route('property-improvements.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Add New Improvement
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Property
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Item Number
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Improvement Type
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Approval Date
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($improvements as $improvement)
                                    <tr>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            {{ $improvement->checklist->property->name }}
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            {{ $improvement->item_number }}
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            {{ $improvement->improvement_type }}
                                            @if ($improvement->sub_type)
                                                <span class="text-gray-500 text-xs">({{ $improvement->sub_type }})</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($improvement->status == 'completed') bg-green-100 text-green-800 
                                                @elseif($improvement->status == 'pending') bg-yellow-100 text-yellow-800 
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($improvement->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            {{ $improvement->approval_date ? $improvement->approval_date->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            <div class="flex">
                                                <a href="{{ route('property-improvements.show', $improvement) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                                                    View
                                                </a>
                                                <a href="{{ route('property-improvements.edit', $improvement) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                    Edit
                                                </a>
                                                <form action="{{ route('property-improvements.destroy', $improvement) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this improvement?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-3 px-4 border-b border-gray-200 text-center text-gray-500">
                                            No property improvements found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $improvements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>