<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Property') }}
            </h2>
            <a href="{{ route('properties-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <div class="mb-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">{{ $property->name }}</h3>
                    <div>
                        <a href="{{ route('properties-info.edit', $property->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 mr-2">
                            Edit
                        </a>
                        <form action="{{ route('properties-info.destroy', $property->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this property?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Basic Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Property Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Portfolio</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->portfolio->portfolio_name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->category }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Batch No</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->batch_no }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Usage</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->usage }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Location</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->address }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">City</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->city }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">State</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->state }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Country</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->country }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Postal Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->postal_code }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Size & Value</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Land Size</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($property->land_size, 2) }} m²</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Gross Floor Area</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($property->gross_floor_area, 2) }} m²</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Value</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($property->value, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Ownership</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $property->ownership }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Share Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($property->share_amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Market Value</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($property->market_value, 2) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Tenants Section -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Tenants</h4>
                    @if ($property->tenants->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Commencement
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Expiry
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($property->tenants as $tenant)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $tenant->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $tenant->contact_person }}<br>
                                                {{ $tenant->email ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $tenant->commencement_date ? date('M d, Y', strtotime($tenant->commencement_date)) : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $tenant->expiry_date ? date('M d, Y', strtotime($tenant->expiry_date)) : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($tenant->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No tenants associated with this property.</p>
                    @endif
                </div>

                <!-- Site Visits Section -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Site Visits</h4>
                    @if ($property->siteVisits->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date & Time
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Inspector
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Notes
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($property->siteVisits as $visit)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ date('M d, Y', strtotime($visit->date_visit)) }}<br>
                                                {{ date('h:i A', strtotime($visit->time_visit)) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $visit->inspector_name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $visit->notes ?? 'No notes' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $visit->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($visit->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ ucfirst($visit->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No site visits recorded for this property.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>