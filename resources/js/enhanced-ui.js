// Enhanced UI functionality for Laravel Management System

// Toast notifications
class ToastManager {
    constructor() {
        this.container = this.createContainer();
        document.body.appendChild(this.container);
    }

    createContainer() {
        const container = document.createElement('div');
        container.className = 'fixed top-4 right-4 z-50 space-y-2';
        container.id = 'toast-container';
        return container;
    }

    show(message, type = 'info', duration = 5000) {
        const toast = this.createToast(message, type);
        this.container.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');
        }, 10);

        // Auto remove
        setTimeout(() => {
            this.remove(toast);
        }, duration);

        return toast;
    }

    createToast(message, type) {
        const colors = {
            success: 'from-green-500 to-green-600',
            error: 'from-red-500 to-red-600',
            warning: 'from-yellow-500 to-orange-500',
            info: 'from-blue-500 to-blue-600'
        };

        const icons = {
            success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
            error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
            warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>',
            info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
        };

        const toast = document.createElement('div');
        toast.className = `transform translate-x-full transition-transform duration-300 ease-out bg-gradient-to-r ${colors[type]} text-white p-4 rounded-xl shadow-lg flex items-center max-w-sm`;
        
        toast.innerHTML = `
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${icons[type]}
            </svg>
            <span class="font-medium">${message}</span>
            <button onclick="toastManager.remove(this.parentElement)" class="ml-auto pl-3 text-white/80 hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;

        return toast;
    }

    remove(toast) {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.parentElement.removeChild(toast);
            }
        }, 300);
    }
}

// Loading overlay
class LoadingManager {
    constructor() {
        this.overlay = this.createOverlay();
        document.body.appendChild(this.overlay);
    }

    createOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 invisible transition-all duration-300';
        overlay.id = 'loading-overlay';
        
        overlay.innerHTML = `
            <div class="bg-white rounded-2xl p-8 shadow-2xl flex flex-col items-center space-y-4">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                <p class="text-gray-700 font-medium">Loading...</p>
            </div>
        `;

        return overlay;
    }

    show(message = 'Loading...') {
        const messageEl = this.overlay.querySelector('p');
        messageEl.textContent = message;
        
        this.overlay.classList.remove('opacity-0', 'invisible');
        this.overlay.classList.add('opacity-100', 'visible');
        document.body.style.overflow = 'hidden';
    }

    hide() {
        this.overlay.classList.remove('opacity-100', 'visible');
        this.overlay.classList.add('opacity-0', 'invisible');
        document.body.style.overflow = '';
    }
}

// Confirmation dialogs
class ConfirmationManager {
    constructor() {
        this.modal = this.createModal();
        document.body.appendChild(this.modal);
    }

    createModal() {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 opacity-0 invisible transition-all duration-300';
        modal.id = 'confirmation-modal';
        
        modal.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform scale-95 transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" id="confirm-title">Confirm Action</h3>
                            <p class="text-gray-600" id="confirm-message">Are you sure you want to proceed?</p>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button id="confirm-cancel" class="btn-secondary">Cancel</button>
                        <button id="confirm-ok" class="btn-danger">Confirm</button>
                    </div>
                </div>
            </div>
        `;

        // Event listeners
        modal.addEventListener('click', (e) => {
            if (e.target === modal) this.hide();
        });

        return modal;
    }

    show(title, message, onConfirm, onCancel = null) {
        const titleEl = this.modal.querySelector('#confirm-title');
        const messageEl = this.modal.querySelector('#confirm-message');
        const cancelBtn = this.modal.querySelector('#confirm-cancel');
        const confirmBtn = this.modal.querySelector('#confirm-ok');

        titleEl.textContent = title;
        messageEl.textContent = message;

        // Remove existing listeners
        cancelBtn.onclick = null;
        confirmBtn.onclick = null;

        // Add new listeners
        cancelBtn.onclick = () => {
            this.hide();
            if (onCancel) onCancel();
        };

        confirmBtn.onclick = () => {
            this.hide();
            if (onConfirm) onConfirm();
        };

        // Show modal
        this.modal.classList.remove('opacity-0', 'invisible');
        this.modal.classList.add('opacity-100', 'visible');
        this.modal.querySelector('.bg-white').classList.remove('scale-95');
        this.modal.querySelector('.bg-white').classList.add('scale-100');
        
        document.body.style.overflow = 'hidden';
    }

    hide() {
        this.modal.classList.remove('opacity-100', 'visible');
        this.modal.classList.add('opacity-0', 'invisible');
        this.modal.querySelector('.bg-white').classList.remove('scale-100');
        this.modal.querySelector('.bg-white').classList.add('scale-95');
        
        document.body.style.overflow = '';
    }
}

// Initialize managers
const toastManager = new ToastManager();
const loadingManager = new LoadingManager();
const confirmationManager = new ConfirmationManager();

// Global functions
window.showToast = (message, type = 'info', duration = 5000) => {
    toastManager.show(message, type, duration);
};

window.showLoading = (message = 'Loading...') => {
    loadingManager.show(message);
};

window.hideLoading = () => {
    loadingManager.hide();
};

window.confirmAction = (title, message, onConfirm, onCancel = null) => {
    confirmationManager.show(title, message, onConfirm, onCancel);
};

// Enhanced form handling
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit forms with loading states
    const forms = document.querySelectorAll('form[data-async]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = `
                <div class="loading-dots">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <span class="ml-2">Processing...</span>
            `;
            submitBtn.disabled = true;
            
            // Submit form via fetch
            const formData = new FormData(form);
            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Operation completed successfully', 'success');
                    if (data.redirect) {
                        setTimeout(() => window.location.href = data.redirect, 1000);
                    }
                } else {
                    showToast(data.message || 'An error occurred', 'error');
                }
            })
            .catch(error => {
                showToast('Network error occurred', 'error');
                console.error('Form submission error:', error);
            })
            .finally(() => {
                // Restore button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    });

    // Enhance delete buttons
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const message = this.dataset.confirmDelete || 'Are you sure you want to delete this item?';
            const url = this.href || this.dataset.url;
            
            confirmAction(
                'Confirm Delete', 
                message,
                () => {
                    if (url) {
                        showLoading('Deleting...');
                        window.location.href = url;
                    }
                }
            );
        });
    });

    // Auto-hide flash messages
    const flashMessages = document.querySelectorAll('.flash-message');
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'all 0.5s ease-out';
            message.style.opacity = '0';
            message.style.transform = 'translateY(-20px)';
            setTimeout(() => message.remove(), 500);
        }, 5000);
    });

    // Smooth scroll for hash links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Back to top button
    const backToTop = document.createElement('button');
    backToTop.className = 'fixed bottom-4 right-4 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 z-40';
    backToTop.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    `;
    
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    document.body.appendChild(backToTop);

    // Show/hide back to top button
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTop.classList.remove('opacity-0', 'invisible');
            backToTop.classList.add('opacity-100', 'visible');
        } else {
            backToTop.classList.remove('opacity-100', 'visible');
            backToTop.classList.add('opacity-0', 'invisible');
        }
    });
});

// Export for use in other modules
export { toastManager, loadingManager, confirmationManager };
