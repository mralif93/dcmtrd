@props(['title', 'icon', 'count', 'href', 'color' => 'bg-blue-100'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => "{$color} rounded-lg shadow-sm p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-1"]) }}>
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-blue-800">{{ $title }}</p>
            <p class="text-3xl font-semibold text-blue-900 mt-2">{{ $count }}</p>
        </div>
        <div class="bg-white p-3 rounded-full shadow-sm">
            <x-icon :name="$icon" class="h-8 w-8 text-blue-600" />
        </div>
    </div>
</a>