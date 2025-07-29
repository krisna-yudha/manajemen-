@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'value' => '',
    'error' => null,
    'helpText' => null,
    'icon' => null
])

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $icon !!}
                </svg>
            </div>
        @endif

        @switch($type)
            @case('textarea')
                <textarea
                    id="{{ $name }}"
                    name="{{ $name }}"
                    placeholder="{{ $placeholder }}"
                    {{ $required ? 'required' : '' }}
                    {{ $disabled ? 'disabled' : '' }}
                    {{ $attributes->merge(['class' => 'form-input' . ($icon ? ' pl-10' : '') . ($error ? ' border-red-300 focus:border-red-500 focus:ring-red-500' : '')]) }}
                    rows="4"
                >{{ old($name, $value) }}</textarea>
                @break

            @case('select')
                <select
                    id="{{ $name }}"
                    name="{{ $name }}"
                    {{ $required ? 'required' : '' }}
                    {{ $disabled ? 'disabled' : '' }}
                    {{ $attributes->merge(['class' => 'form-select' . ($icon ? ' pl-10' : '') . ($error ? ' border-red-300 focus:border-red-500 focus:ring-red-500' : '')]) }}
                >
                    {{ $slot }}
                </select>
                @break

            @case('checkbox')
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="{{ $name }}"
                        name="{{ $name }}"
                        value="1"
                        {{ old($name, $value) ? 'checked' : '' }}
                        {{ $required ? 'required' : '' }}
                        {{ $disabled ? 'disabled' : '' }}
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    >
                    @if($label)
                        <label for="{{ $name }}" class="ml-2 text-sm text-gray-700 cursor-pointer">
                            {{ $label }}
                            @if($required)
                                <span class="text-red-500 ml-1">*</span>
                            @endif
                        </label>
                    @endif
                </div>
                @break

            @case('radio')
                {{ $slot }}
                @break

            @case('file')
                <div class="relative">
                    <input
                        type="file"
                        id="{{ $name }}"
                        name="{{ $name }}"
                        {{ $required ? 'required' : '' }}
                        {{ $disabled ? 'disabled' : '' }}
                        {{ $attributes->merge(['class' => 'hidden']) }}
                        onchange="updateFileName(this)"
                    >
                    <label for="{{ $name }}" class="form-input cursor-pointer flex items-center justify-between {{ $error ? ' border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}">
                        <span class="text-gray-500" id="{{ $name }}_filename">{{ $placeholder ?: 'Choose file...' }}</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </label>
                </div>
                @break

            @default
                <input
                    type="{{ $type }}"
                    id="{{ $name }}"
                    name="{{ $name }}"
                    placeholder="{{ $placeholder }}"
                    value="{{ old($name, $value) }}"
                    {{ $required ? 'required' : '' }}
                    {{ $disabled ? 'disabled' : '' }}
                    {{ $attributes->merge(['class' => 'form-input' . ($icon ? ' pl-10' : '') . ($error ? ' border-red-300 focus:border-red-500 focus:ring-red-500' : '')]) }}
                >
        @endswitch
    </div>

    @if($error)
        <p class="text-sm text-red-600 flex items-center">
            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            {{ $error }}
        </p>
    @elseif($helpText)
        <p class="text-sm text-gray-500 flex items-center">
            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ $helpText }}
        </p>
    @endif
</div>

@if($type === 'file')
    @push('scripts')
    <script>
        function updateFileName(input) {
            const filename = input.files[0]?.name || 'Choose file...';
            const label = document.getElementById(input.id + '_filename');
            if (label) {
                label.textContent = filename;
                label.parentElement.classList.add('border-blue-300', 'bg-blue-50');
            }
        }
    </script>
    @endpush
@endif
