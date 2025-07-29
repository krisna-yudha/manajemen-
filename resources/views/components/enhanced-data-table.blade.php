@props([
    'data' => collect(),
    'columns' => [],
    'actions' => [],
    'filters' => [],
    'searchPlaceholder' => 'Search...',
    'searchValue' => '',
    'paginate' => false,
    'emptyTitle' => 'No data found',
    'emptyDescription' => 'No items match your current filters.',
    'emptyAction' => null
])

<div class="modern-card overflow-hidden">
    <!-- Filters and Search -->
    @if(!empty($filters) || $searchValue !== '')
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search"
                            value="{{ $searchValue }}"
                            class="form-input pl-10" 
                            placeholder="{{ $searchPlaceholder }}"
                        >
                    </div>
                </div>

                <!-- Filters -->
                @foreach($filters as $filter)
                    <div class="min-w-0 flex-shrink-0 sm:w-48">
                        @if($filter['type'] === 'select')
                            <select name="{{ $filter['name'] }}" class="form-input">
                                @foreach($filter['options'] as $value => $label)
                                    <option value="{{ $value }}" {{ $filter['current'] == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                @endforeach

                <!-- Submit Button -->
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter
                </button>
                
                @if($searchValue || collect($filters)->contains(fn($f) => !empty($f['current'])))
                    <a href="{{ request()->url() }}" class="btn-secondary">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead>
                <tr>
                    @foreach($columns as $column)
                        <th class="{{ $column['sortable'] ?? false ? 'cursor-pointer hover:bg-gray-100' : '' }}">
                            <div class="flex items-center space-x-2">
                                <span>{{ $column['label'] }}</span>
                                @if($column['sortable'] ?? false)
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                    @endforeach
                    @if(!empty($actions))
                        <th class="text-right">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        @foreach($columns as $column)
                            <td>
                                @if($column['type'] === 'avatar')
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($item->{$column['name_field']}, 0, 2)) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900">{{ $item->{$column['name_field']} }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->{$column['email_field']} }}</div>
                                        </div>
                                    </div>
                                @elseif($column['type'] === 'badge')
                                    @php
                                        if (isset($column['badge_field'])) {
                                            $badgeValue = $item->{$column['badge_field']};
                                            $badgeConfig = $column['badge_values'][$badgeValue] ?? null;
                                            $badgeText = $badgeConfig['label'] ?? $badgeValue;
                                            $badgeColor = $badgeConfig['color'] ?? 'gray';
                                        } else {
                                            $value = $item->{$column['key']};
                                            $badgeText = ucfirst($value);
                                            $badgeColor = $column['badge_colors'][$value] ?? 'gray';
                                        }
                                    @endphp
                                    <span class="badge badge-{{ $badgeColor }}">
                                        {{ $badgeText }}
                                    </span>
                                @elseif($column['type'] === 'date')
                                    <span class="text-gray-600">
                                        {{ $item->{$column['key']}->format('d M Y') }}
                                    </span>
                                @else
                                    {{ $item->{$column['key']} }}
                                @endif
                            </td>
                        @endforeach
                        
                        @if(!empty($actions))
                            <td class="text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @foreach($actions as $action)
                                        @php
                                            $label = is_callable($action['label']) ? $action['label']($item) : $action['label'];
                                            $color = is_callable($action['color'] ?? null) ? $action['color']($item) : ($action['color'] ?? 'blue');
                                            $confirm = is_callable($action['confirm'] ?? null) ? $action['confirm']($item) : ($action['confirm'] ?? null);
                                        @endphp
                                        
                                        @if(isset($action['method']) && $action['method'] !== 'GET')
                                            <form method="POST" action="{{ route($action['route'], $item) }}" class="inline">
                                                @csrf
                                                @method($action['method'])
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200 bg-{{ $color }}-100 text-{{ $color }}-700 hover:bg-{{ $color }}-200"
                                                        @if($confirm) onclick="return confirm('{{ $confirm }}')" @endif>
                                                    {{ $label }}
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route($action['route'], $item) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200 bg-{{ $color }}-100 text-{{ $color }}-700 hover:bg-{{ $color }}-200">
                                                {{ $label }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + (!empty($actions) ? 1 : 0) }}" class="text-center py-12">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">{{ $emptyTitle }}</p>
                                <p class="text-gray-400 text-sm mt-1">{{ $emptyDescription }}</p>
                                @if($emptyAction)
                                    <a href="{{ route($emptyAction['route']) }}" class="btn-primary mt-4">
                                        @if(isset($emptyAction['icon']))
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                {!! $emptyAction['icon'] !!}
                                            </svg>
                                        @endif
                                        {{ $emptyAction['label'] }}
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($paginate && method_exists($data, 'links'))
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() ?? 0 }} results
                </div>
                <div class="flex items-center space-x-2">
                    {{ $data->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
