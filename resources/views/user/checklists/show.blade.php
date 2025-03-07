<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checklist Details') }}
            </h2>
            <a href="{{ route('checklists-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Checklist: {{ ucfirst($checklist->type) }} - {{ $checklist->property->name ?? 'N/A' }}</h3>
                    <div>
                        <a href="{{ route('checklists-info.edit', $checklist->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 mr-2">
                            Edit
                        </a>
                        <form action="{{ route('checklists-info.destroy', $checklist->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this checklist?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Basic Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Property</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->property->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($checklist->type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->status == 'completed' ? 'bg-green-100 text-green-800' : ($checklist->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($checklist->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->description ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->approval_date ? $checklist->approval_date->format('M d, Y') : 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Response Time (Days)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->response_time_days ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Department Information -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Department Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Assigned Department</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->assigned_department }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Verifying Department</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->verifying_department ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Signature Information -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Signature Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->prepared_by ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Prepared Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->prepared_date ? $checklist->prepared_date->format('M d, Y') : 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Confirmed By</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->confirmed_by ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Confirmed Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $checklist->confirmed_date ? $checklist->confirmed_date->format('M d, Y') : 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Documentation Items (if applicable) -->
                @if($checklist->type == 'documentation' && $checklist->documentationItems->count() > 0)
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Documentation Items</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Item Number
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Document Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Validity Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Location
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($checklist->documentationItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item->item_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->document_type }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->validity_date ? $item->validity_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->location ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Tenant Approvals (if applicable) -->
                @if($checklist->type == 'tenant' && $checklist->tenantApprovals->count() > 0)
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Tenant Approvals</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tenant
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Approval Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        OD Approved
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        LD Verified
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Submitted Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Response Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($checklist->tenantApprovals as $approval)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $approval->tenant->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucfirst($approval->approval_type) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $approval->od_approved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $approval->od_approved ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $approval->ld_verified ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $approval->ld_verified ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $approval->submitted_to_ld_date ? $approval->submitted_to_ld_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $approval->ld_response_date ? $approval->ld_response_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Condition Checks (if applicable) -->
                @if($checklist->type == 'condition' && $checklist->conditionChecks->count() > 0)
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Condition Checks</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Section
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Item Number
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Item Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Satisfied
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Remarks
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($checklist->conditionChecks as $check)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $check->section }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $check->item_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $check->item_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $check->is_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $check->is_satisfied ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $check->remarks ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Property Improvements (if applicable) -->
                @if($checklist->type == 'improvement' && $checklist->propertyImprovements->count() > 0)
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Property Improvements</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Item Number
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sub Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Approval Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Scope of Work
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($checklist->propertyImprovements as $improvement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $improvement->item_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $improvement->improvement_type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $improvement->sub_type ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $improvement->approval_date ? $improvement->approval_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $improvement->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                              ($improvement->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($improvement->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $improvement->scope_of_work ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Metadata -->
                <div class="mt-8 pt-4 border-t border-gray-200 text-sm text-gray-500">
                    <p>Created: {{ $checklist->created_at->format('M d, Y H:i') }}</p>
                    <p>Last Updated: {{ $checklist->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>