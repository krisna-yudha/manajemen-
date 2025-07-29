@props([
    'headers' => [],
    'rows' => [],
    'searchable' => true,
    'sortable' => true,
    'pagination' => null,
    'emptyMessage' => 'No data available',
    'actions' => null
])

<div class="modern-card overflow-hidden">
    @if($searchable || $actions)
        <!-- Table Header with Search and Actions -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            @if($searchable)
                <div class="relative mb-4 sm:mb-0">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="table-search"
                        class="form-input pl-10 sm:w-64" 
                        placeholder="Search..."
                        onkeyup="filterTable()"
                    >
                </div>
            @endif
            
            @if($actions)
                <div class="flex items-center space-x-3">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    <!-- Table Container -->
    <div class="overflow-x-auto">
        <table class="table-modern" id="data-table">
            <thead>
                <tr>
                    @foreach($headers as $index => $header)
                        <th class="{{ $sortable ? 'cursor-pointer hover:bg-gray-100 select-none' : '' }}" 
                            @if($sortable) onclick="sortTable({{ $index }})" @endif>
                            <div class="flex items-center space-x-2">
                                <span>{{ is_array($header) ? $header['label'] : $header }}</span>
                                @if($sortable)
                                    <svg class="w-4 h-4 text-gray-400 sort-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody id="table-body">
                @forelse($rows as $rowIndex => $row)
                    <tr class="animate-fadeIn" style="animation-delay: {{ $rowIndex * 0.05 }}s">
                        @foreach($row as $cellIndex => $cell)
                            <td>
                                @if(is_array($cell) && isset($cell['type']))
                                    @switch($cell['type'])
                                        @case('badge')
                                            <span class="badge badge-{{ $cell['color'] ?? 'secondary' }}">
                                                {{ $cell['text'] }}
                                            </span>
                                            @break
                                        @case('avatar')
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-r {{ $cell['gradient'] ?? 'from-blue-500 to-purple-500' }} flex items-center justify-center text-white font-semibold">
                                                    {{ $cell['initials'] ?? substr($cell['name'], 0, 2) }}
                                                </div>
                                                @if(isset($cell['name']))
                                                    <div class="ml-3">
                                                        <div class="font-medium text-gray-900">{{ $cell['name'] }}</div>
                                                        @if(isset($cell['subtitle']))
                                                            <div class="text-sm text-gray-500">{{ $cell['subtitle'] }}</div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            @break
                                        @case('actions')
                                            <div class="flex items-center space-x-2">
                                                @foreach($cell['buttons'] as $button)
                                                    @if($button['type'] === 'link')
                                                        <a href="{{ $button['url'] }}" 
                                                           class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200 {{ $button['class'] ?? 'bg-blue-100 text-blue-700 hover:bg-blue-200' }}"
                                                           @if(isset($button['tooltip'])) title="{{ $button['tooltip'] }}" @endif>
                                                            @if(isset($button['icon']))
                                                                <svg class="w-4 h-4 {{ isset($button['text']) ? 'mr-1' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    {!! $button['icon'] !!}
                                                                </svg>
                                                            @endif
                                                            {{ $button['text'] ?? '' }}
                                                        </a>
                                                    @elseif($button['type'] === 'button')
                                                        <button type="button"
                                                                onclick="{{ $button['onclick'] ?? '' }}"
                                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200 {{ $button['class'] ?? 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                                                @if(isset($button['tooltip'])) title="{{ $button['tooltip'] }}" @endif>
                                                            @if(isset($button['icon']))
                                                                <svg class="w-4 h-4 {{ isset($button['text']) ? 'mr-1' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    {!! $button['icon'] !!}
                                                                </svg>
                                                            @endif
                                                            {{ $button['text'] ?? '' }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @break
                                        @case('currency')
                                            <span class="font-medium text-gray-900">
                                                {{ $cell['currency'] ?? 'Rp' }} {{ number_format($cell['amount'], 0, ',', '.') }}
                                            </span>
                                            @break
                                        @case('date')
                                            <span class="text-gray-600">
                                                {{ date($cell['format'] ?? 'd M Y', strtotime($cell['date'])) }}
                                            </span>
                                            @break
                                        @default
                                            {{ $cell['text'] ?? $cell }}
                                    @endswitch
                                @else
                                    {{ $cell }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) }}" class="text-center py-12">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">{{ $emptyMessage }}</p>
                                <p class="text-gray-400 text-sm mt-1">Try adjusting your search or filter criteria</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pagination)
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $pagination->firstItem() ?? 0 }} to {{ $pagination->lastItem() ?? 0 }} of {{ $pagination->total() ?? 0 }} results
                </div>
                <div class="flex items-center space-x-2">
                    {{ $pagination->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    let sortDirection = 1; // 1 for ascending, -1 for descending
    let lastSortedColumn = -1;

    function filterTable() {
        const input = document.getElementById('table-search');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('data-table');
        const tbody = document.getElementById('table-body');
        const rows = tbody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }

            if (found) {
                row.style.display = '';
                row.classList.add('animate-fadeIn');
            } else {
                row.style.display = 'none';
                row.classList.remove('animate-fadeIn');
            }
        }
    }

    function sortTable(columnIndex) {
        const table = document.getElementById('data-table');
        const tbody = document.getElementById('table-body');
        const rows = Array.from(tbody.getElementsByTagName('tr'));
        
        // Update sort direction
        if (lastSortedColumn === columnIndex) {
            sortDirection *= -1;
        } else {
            sortDirection = 1;
            lastSortedColumn = columnIndex;
        }

        // Sort rows
        rows.sort((a, b) => {
            const cellA = a.getElementsByTagName('td')[columnIndex];
            const cellB = b.getElementsByTagName('td')[columnIndex];
            
            if (!cellA || !cellB) return 0;
            
            const textA = cellA.textContent.trim().toLowerCase();
            const textB = cellB.textContent.trim().toLowerCase();
            
            // Try to parse as numbers
            const numA = parseFloat(textA.replace(/[^\d.-]/g, ''));
            const numB = parseFloat(textB.replace(/[^\d.-]/g, ''));
            
            if (!isNaN(numA) && !isNaN(numB)) {
                return (numA - numB) * sortDirection;
            }
            
            // Sort as text
            return textA.localeCompare(textB) * sortDirection;
        });

        // Update sort icons
        const sortIcons = table.querySelectorAll('.sort-icon');
        sortIcons.forEach((icon, index) => {
            if (index === columnIndex) {
                icon.style.transform = sortDirection === 1 ? 'rotate(0deg)' : 'rotate(180deg)';
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-blue-600');
            } else {
                icon.style.transform = 'rotate(0deg)';
                icon.classList.remove('text-blue-600');
                icon.classList.add('text-gray-400');
            }
        });

        // Re-append sorted rows
        rows.forEach((row, index) => {
            tbody.appendChild(row);
            row.style.animationDelay = `${index * 0.02}s`;
            row.classList.remove('animate-fadeIn');
            setTimeout(() => row.classList.add('animate-fadeIn'), 10);
        });
    }

    // Initialize tooltips if available
    document.addEventListener('DOMContentLoaded', function() {
        const elementsWithTooltip = document.querySelectorAll('[title]');
        elementsWithTooltip.forEach(element => {
            element.addEventListener('mouseenter', function() {
                // Add tooltip styling
                this.style.position = 'relative';
            });
        });
    });
</script>
@endpush
