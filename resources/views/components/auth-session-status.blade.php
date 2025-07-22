@props(['status'])

@if ($status)
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
        <p class="text-sm text-green-800 text-center font-medium">
            ✓ {{ $status }}
        </p>
    </div>
@endif
