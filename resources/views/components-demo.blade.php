<x-enhanced-layout>
    <x-slot name="title">UI Components Demo</x-slot>

    <x-slot name="actions">
        <a href="{{ route('dashboard') }}" class="btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </x-slot>

    <x-slot name="stats">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-2xl font-bold text-blue-600">8</div>
                        <div class="text-sm text-gray-600">Total Components</div>
                    </div>
                </div>
            </div>
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-2xl font-bold text-green-600">50+</div>
                        <div class="text-sm text-gray-600">CSS Classes</div>
                    </div>
                </div>
            </div>
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-2xl font-bold text-purple-600">12</div>
                        <div class="text-sm text-gray-600">JavaScript Features</div>
                    </div>
                </div>
            </div>
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-2xl font-bold text-indigo-600">3</div>
                        <div class="text-sm text-gray-600">Alpine.js Plugins</div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="breadcrumbs">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">UI Components Demo</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <!-- Clickability Debug Section -->
    <div class="card-modern">
        <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">🔧 Clickability Debug</h3>
            <p class="text-red-100 text-sm">Debug tools for mouse click issues</p>
        </div>
        <div class="p-6 space-y-4">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="font-medium text-yellow-800 mb-2">Diagnostic Tools</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <button type="button" 
                            onclick="window.debugClickability()"
                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-sm"
                            style="cursor: pointer !important; pointer-events: auto !important;">
                        📊 Debug Info
                    </button>
                    
                    <button type="button" 
                            onclick="window.testAllButtons()"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm"
                            style="cursor: pointer !important; pointer-events: auto !important;">
                        🧪 Test All Buttons
                    </button>
                    
                    <button type="button" 
                            onclick="window.highlightClickable()"
                            class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded text-sm"
                            style="cursor: pointer !important; pointer-events: auto !important;">
                        ✨ Highlight Clickable
                    </button>
                </div>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-medium text-blue-800 mb-2">Mouse Click Tests</h4>
                <div class="space-y-2">
                    <button type="button" 
                            onclick="alert('Standard onclick works!')"
                            class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded"
                            style="cursor: pointer !important;">
                        Test Standard onClick
                    </button>
                    
                    <button type="button" 
                            class="btn-primary w-full"
                            onclick="alert('CSS class button works!')">
                        Test CSS Class Button
                    </button>
                    
                    <div x-data="{ clicked: false }">
                        <button type="button" 
                                @click="clicked = !clicked; alert('Alpine.js click works!')"
                                class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded"
                                style="cursor: pointer !important;">
                            Test Alpine.js Click (Clicked: <span x-text="clicked ? 'Yes' : 'No'"></span>)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons Demo -->
    <div class="card-modern">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">Enhanced Buttons</h3>
            <p class="text-blue-100 text-sm">Modern button styles with gradients and animations</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button class="btn-primary" type="button" @click="$dispatch('button-clicked', 'Primary')">Primary</button>
                <button class="btn-secondary" type="button" @click="$dispatch('button-clicked', 'Secondary')">Secondary</button>
                <button class="btn-success" type="button" @click="$dispatch('button-clicked', 'Success')">Success</button>
                <button class="btn-danger" type="button" @click="$dispatch('button-clicked', 'Danger')">Danger</button>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <code class="bg-gray-100 px-2 py-1 rounded">.btn-primary</code>
                <code class="bg-gray-100 px-2 py-1 rounded ml-2">.btn-secondary</code>
                <code class="bg-gray-100 px-2 py-1 rounded ml-2">.btn-success</code>
                <code class="bg-gray-100 px-2 py-1 rounded ml-2">.btn-danger</code>
            </div>
        </div>
    </div>

    <!-- Form Components Demo -->
    <div class="card-modern">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">Form Components</h3>
            <p class="text-green-100 text-sm">Reusable form inputs with validation states</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-input 
                    name="demo_text"
                    label="Text Input"
                    placeholder="Enter some text..."
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>'
                />
                
                <x-form-input 
                    name="demo_email"
                    type="email"
                    label="Email Input"
                    placeholder="email@example.com"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>'
                />
                
                <div>
                    <label class="form-label">Select Input</label>
                    <select class="form-input">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                    </select>
                </div>
                
                <div>
                    <label class="form-label">Textarea</label>
                    <textarea class="form-input" rows="3" placeholder="Enter description..."></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Badges Demo -->
    <div class="card-modern">
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">Badge Components</h3>
            <p class="text-purple-100 text-sm">Colorful status indicators</p>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <span class="badge-blue">Blue Badge</span>
                <span class="badge-green">Success</span>
                <span class="badge-red">Error</span>
                <span class="badge-yellow">Warning</span>
                <span class="badge-purple">Info</span>
                <span class="badge-gray">Neutral</span>
            </div>
        </div>
    </div>

    <!-- Loading States Demo -->
    <div class="card-modern">
        <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">Loading States</h3>
            <p class="text-orange-100 text-sm">Animated loading indicators</p>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center space-x-4">
                <div class="loading-spinner"></div>
                <span class="text-gray-600">Loading spinner</span>
            </div>
            
            <div class="space-y-2">
                <div class="text-sm text-gray-600">Loading progress bars:</div>
                <div class="loading-bar">
                    <div class="loading-progress" style="width: 25%"></div>
                </div>
                <div class="loading-bar">
                    <div class="loading-progress" style="width: 75%"></div>
                </div>
            </div>
            
            <button class="btn-primary" 
                    type="button"
                    id="demo-loading-btn"
                    @click="$dispatch('show-loading', 'Demo loading...')">
                Show Loading Overlay
            </button>
        </div>
    </div>

    <!-- Interactive Features Demo -->
    <div class="card-modern" x-data="{ 
        showToast: false,
        modalOpen: false,
        count: 0 
    }">
        <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">Interactive Features</h3>
            <p class="text-teal-100 text-sm">Alpine.js powered components</p>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button class="btn-primary" 
                        type="button"
                        @click="$dispatch('show-toast', { type: 'success', message: 'Toast notification demo!' })">
                    Show Toast
                </button>
                
                <button class="btn-secondary" 
                        type="button"
                        @click="modalOpen = true">
                    Open Modal
                </button>
                
                <div class="flex items-center space-x-2">
                    <button class="btn-secondary" type="button" @click="count--">-</button>
                    <span class="px-4 py-2 bg-gray-100 rounded font-mono" x-text="count"></span>
                    <button class="btn-secondary" type="button" @click="count++">+</button>
                </div>
            </div>
            
            <!-- Simple Modal Demo -->
            <div x-show="modalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                 style="z-index: 9999;"
                 @click.self="modalOpen = false"
                 @keydown.escape.window="modalOpen = false">
                <div class="bg-white rounded-xl p-6 max-w-md mx-4 shadow-xl border">
                    <h4 class="text-lg font-semibold mb-4 text-gray-900">Demo Modal</h4>
                    <p class="text-gray-600 mb-6">This is a demo modal using Alpine.js transitions!</p>
                    <div class="flex justify-end space-x-3">
                        <button class="btn-secondary" type="button" @click="modalOpen = false">Close</button>
                        <button class="btn-primary" type="button" @click="modalOpen = false">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Animation Demo -->
    <div class="card-modern">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">Animations</h3>
            <p class="text-indigo-100 text-sm">Smooth transitions and effects</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="card-hover p-4 text-center bg-gray-50 rounded-lg">
                    <div class="text-2xl mb-2">🎯</div>
                    <div class="font-medium">Hover Effect</div>
                </div>
                
                <div class="scale-animation p-4 text-center bg-gray-50 rounded-lg cursor-pointer">
                    <div class="text-2xl mb-2">📦</div>
                    <div class="font-medium">Scale Animation</div>
                </div>
                
                <div class="slide-in p-4 text-center bg-gray-50 rounded-lg">
                    <div class="text-2xl mb-2">✨</div>
                    <div class="font-medium">Slide In</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Component Usage Instructions -->
    <div class="card-modern">
        <div class="bg-gradient-to-r from-gray-700 to-gray-900 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">How to Use Components</h3>
            <p class="text-gray-300 text-sm">Quick reference for implementation</p>
        </div>
        <div class="p-6 space-y-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold mb-2">Enhanced Layout Component</h4>
                <pre class="text-sm text-gray-700 overflow-x-auto"><code>&lt;x-enhanced-layout&gt;
    &lt;x-slot name="title"&gt;Page Title&lt;/x-slot&gt;
    &lt;x-slot name="actions"&gt;Action buttons&lt;/x-slot&gt;
    &lt;x-slot name="stats"&gt;Statistics data&lt;/x-slot&gt;
    &lt;x-slot name="breadcrumbs"&gt;Breadcrumb data&lt;/x-slot&gt;
    
    Content here...
&lt;/x-enhanced-layout&gt;</code></pre>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold mb-2">Form Input Component</h4>
                <pre class="text-sm text-gray-700 overflow-x-auto"><code>&lt;x-form-input 
    name="field_name"
    label="Field Label"
    placeholder="Enter value..."
    type="text"
    :value="old('field_name')"
    required="true"
    icon="svg_icon_path"
/&gt;</code></pre>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold mb-2">Data Table Component</h4>
                <pre class="text-sm text-gray-700 overflow-x-auto"><code>&lt;x-data-table 
    :data="$collection"
    :columns="$columnsArray"
    :actions="$actionsArray"
    :filters="$filtersArray"
    search-placeholder="Search..."
    :paginate="true"
/&gt;</code></pre>
            </div>
        </div>
    </div>

</x-enhanced-layout>

@push('scripts')
<script>
// Global debug functions
window.testAllButtons = function() {
    console.log('Testing all buttons...');
    const buttons = document.querySelectorAll('button');
    let workingCount = 0;
    let totalCount = buttons.length;
    
    buttons.forEach((btn, index) => {
        try {
            // Test if button is clickable
            const rect = btn.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            const elementAtPoint = document.elementFromPoint(centerX, centerY);
            
            if (elementAtPoint === btn || btn.contains(elementAtPoint)) {
                workingCount++;
                btn.style.border = '2px solid green';
            } else {
                btn.style.border = '2px solid red';
            }
            
            setTimeout(() => {
                btn.style.border = '';
            }, 2000);
        } catch (e) {
            console.error(`Error testing button ${index}:`, e);
        }
    });
    
    alert(`Button Test Results:\n${workingCount}/${totalCount} buttons are properly clickable`);
};

window.highlightClickable = function() {
    console.log('Highlighting clickable elements...');
    const clickableElements = document.querySelectorAll('button, a, [role="button"], [onclick], [@click], [x-on\\:click]');
    
    clickableElements.forEach(element => {
        element.style.outline = '3px solid lime';
        element.style.outlineOffset = '2px';
        
        setTimeout(() => {
            element.style.outline = '';
            element.style.outlineOffset = '';
        }, 3000);
    });
    
    alert(`Highlighted ${clickableElements.length} clickable elements for 3 seconds`);
};

// Ensure Alpine.js is loaded
document.addEventListener('alpine:init', () => {
    console.log('Alpine.js initialized for components demo');
    
    // Global event listeners
    document.addEventListener('button-clicked', (e) => {
        console.log('Button clicked:', e.detail);
        // Show a simple alert or toast
        if (typeof EnhancedUI !== 'undefined' && EnhancedUI.ToastManager) {
            EnhancedUI.ToastManager.show('info', `${e.detail} button clicked!`);
        } else {
            alert(`${e.detail} button clicked!`);
        }
    });
    
    document.addEventListener('show-toast', (e) => {
        console.log('Show toast event:', e.detail);
        if (typeof EnhancedUI !== 'undefined' && EnhancedUI.ToastManager) {
            EnhancedUI.ToastManager.show(e.detail.type, e.detail.message);
        } else {
            alert(e.detail.message);
        }
    });
    
    document.addEventListener('show-loading', (e) => {
        console.log('Show loading event:', e.detail);
        if (typeof EnhancedUI !== 'undefined' && EnhancedUI.LoadingManager) {
            EnhancedUI.LoadingManager.show(e.detail);
            setTimeout(() => {
                EnhancedUI.LoadingManager.hide();
            }, 2000);
        } else {
            alert('Loading: ' + e.detail);
        }
    });
});

// Demo specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Components demo page loaded');
    
    // Add click feedback to all clickable elements
    const clickableElements = document.querySelectorAll('button, a, [role="button"]');
    clickableElements.forEach(element => {
        element.style.cursor = 'pointer';
        element.addEventListener('click', function(e) {
            // Add visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
    });
    
    // Check if EnhancedUI is available
    if (typeof EnhancedUI !== 'undefined') {
        console.log('EnhancedUI loaded successfully');
    } else {
        console.warn('EnhancedUI not found - fallback to alerts');
    }
    
    // Add some interactivity to animation demo cards
    const animationCards = document.querySelectorAll('.scale-animation');
    animationCards.forEach(card => {
        card.addEventListener('click', function() {
            this.style.transform = 'scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
    });
    
    // Test clickability after page load
    setTimeout(() => {
        console.log('=== POST-LOAD CLICKABILITY CHECK ===');
        const allButtons = document.querySelectorAll('button');
        allButtons.forEach((btn, index) => {
            const styles = window.getComputedStyle(btn);
            if (styles.pointerEvents === 'none') {
                console.warn(`Button ${index} has pointer-events: none`, btn);
            }
            if (styles.cursor !== 'pointer') {
                console.warn(`Button ${index} doesn't have cursor: pointer`, btn);
            }
        });
    }, 1000);
});
</script>
@endpush
