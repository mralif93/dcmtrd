@props([
    'title', 
    'icon', 
    'count', 
    'pendingCount' => 0, 
    'href', 
    'color' => 'bg-blue-100'
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => "{$color} rounded-lg shadow-sm p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-1"]) }}>
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-blue-800">{{ $title }}</p>
            <div class="mt-2 flex items-baseline">
                <p class="text-3xl font-semibold text-blue-900">{{ $count }}</p>
                @if($pendingCount > 0)
                    <p class="ml-2 text-sm font-medium text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">
                        {{ $pendingCount }} pending
                    </p>
                @endif
            </div>
        </div>
        <div class="bg-white p-3 rounded-full shadow-sm">
            <x-icon :name="$icon" class="h-8 w-8 text-blue-600" />
        </div>
    </div>
</a>