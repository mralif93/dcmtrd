<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Total Properties</div>
                        <div class="text-2xl font-bold">{{ $totalProperties }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Total Units</div>
                        <div class="text-2xl font-bold">{{ $totalUnits }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Occupancy Rate</div>
                        <div class="text-2xl font-bold">{{ $occupancyRate }}%</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Monthly Revenue</div>
                        <div class="text-2xl font-bold">${{ number_format($monthlyRevenue) }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities and Alerts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Activities -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Recent Activities</h3>
                        <div class="space-y-4">
                            @foreach($recentActivities as $activity)
                            <div class="border-b pb-3">
                                <div class="text-sm">{{ $activity->description }}</div>
                                <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Alerts and Notifications -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Alerts & Notifications</h3>
                        <div class="space-y-4">
                            @foreach($alerts as $alert)
                            <div class="flex items-center border-b pb-3">
                                <div class="flex-1">
                                    <div class="text-sm">{{ $alert->message }}</div>
                                    <div class="text-xs text-gray-500">{{ $alert->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="ml-4">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($alert->priority === 'high') bg-red-100 text-red-800
                                        @elseif($alert->priority === 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($alert->priority) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>