import './bootstrap';
import './manager-reports';
import './enhanced-ui';
import './clickability-fix';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

// Register Alpine plugins
Alpine.plugin(focus);
Alpine.plugin(collapse);

// Global Alpine stores
Alpine.store('theme', {
    dark: false,
    toggle() {
        this.dark = !this.dark;
        document.documentElement.classList.toggle('dark', this.dark);
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
    },
    init() {
        this.dark = localStorage.getItem('theme') === 'dark' || 
                   (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
        document.documentElement.classList.toggle('dark', this.dark);
    }
});

Alpine.store('notifications', {
    items: [],
    add(notification) {
        const id = Date.now();
        this.items.push({ id, ...notification });
        
        // Auto remove after delay
        setTimeout(() => {
            this.remove(id);
        }, notification.duration || 5000);
    },
    remove(id) {
        this.items = this.items.filter(item => item.id !== id);
    },
    clear() {
        this.items = [];
    }
});

// Global Alpine data
Alpine.data('searchable', () => ({
    search: '',
    items: [],
    filteredItems() {
        if (!this.search) return this.items;
        return this.items.filter(item => 
            Object.values(item).some(value => 
                String(value).toLowerCase().includes(this.search.toLowerCase())
            )
        );
    }
}));

Alpine.data('sortable', () => ({
    sortBy: '',
    sortOrder: 'asc',
    sort(key) {
        if (this.sortBy === key) {
            this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortBy = key;
            this.sortOrder = 'asc';
        }
    },
    sortedItems(items) {
        if (!this.sortBy) return items;
        
        return [...items].sort((a, b) => {
            let aVal = a[this.sortBy];
            let bVal = b[this.sortBy];
            
            // Handle numbers
            if (!isNaN(aVal) && !isNaN(bVal)) {
                aVal = Number(aVal);
                bVal = Number(bVal);
            }
            
            // Handle dates
            if (Date.parse(aVal) && Date.parse(bVal)) {
                aVal = new Date(aVal);
                bVal = new Date(bVal);
            }
            
            if (aVal < bVal) return this.sortOrder === 'asc' ? -1 : 1;
            if (aVal > bVal) return this.sortOrder === 'asc' ? 1 : -1;
            return 0;
        });
    }
}));

Alpine.data('modal', () => ({
    open: false,
    show() {
        this.open = true;
        document.body.style.overflow = 'hidden';
    },
    hide() {
        this.open = false;
        document.body.style.overflow = '';
    },
    toggle() {
        this.open ? this.hide() : this.show();
    }
}));

Alpine.data('dropdown', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    }
}));

Alpine.data('formValidation', () => ({
    errors: {},
    touched: {},
    
    validate(field, value, rules) {
        this.touched[field] = true;
        this.errors[field] = [];
        
        for (const rule of rules) {
            const [ruleName, ruleValue] = rule.split(':');
            
            switch (ruleName) {
                case 'required':
                    if (!value || value.trim() === '') {
                        this.errors[field].push(`${field} is required`);
                    }
                    break;
                case 'min':
                    if (value && value.length < parseInt(ruleValue)) {
                        this.errors[field].push(`${field} must be at least ${ruleValue} characters`);
                    }
                    break;
                case 'max':
                    if (value && value.length > parseInt(ruleValue)) {
                        this.errors[field].push(`${field} must not exceed ${ruleValue} characters`);
                    }
                    break;
                case 'email':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (value && !emailRegex.test(value)) {
                        this.errors[field].push(`${field} must be a valid email address`);
                    }
                    break;
            }
        }
        
        if (this.errors[field].length === 0) {
            delete this.errors[field];
        }
    },
    
    hasError(field) {
        return this.errors[field] && this.errors[field].length > 0;
    },
    
    getError(field) {
        return this.errors[field] ? this.errors[field][0] : '';
    },
    
    isValid() {
        return Object.keys(this.errors).length === 0;
    }
}));

window.Alpine = Alpine;
Alpine.start();

// Initialize theme store
Alpine.store('theme').init();

// Global utility functions
window.utils = {
    formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    },
    
    formatDate(date, options = {}) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            ...options
        }).format(new Date(date));
    },
    
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    showNotification(message, type = 'info', duration = 5000) {
        Alpine.store('notifications').add({
            message,
            type,
            duration
        });
    },
    
    copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            this.showNotification('Copied to clipboard!', 'success');
        }).catch(() => {
            this.showNotification('Failed to copy', 'error');
        });
    }
};
