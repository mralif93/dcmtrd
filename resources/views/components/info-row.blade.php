<!-- resources/views/components/info-row.blade.php -->
@props(['label', 'value'])
<div class="flex justify-between items-center py-2">
    <span class="text-sm font-medium text-gray-600">{{ $label }}:</span>
    <span class="text-sm text-gray-900">{{ $value ?? 'N/A' }}</span>
</div>