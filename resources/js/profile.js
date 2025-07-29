// Profile Page Interactive Components
document.addEventListener('alpine:init', () => {
    Alpine.data('profileManager', () => ({
        activeTab: 'profile',
        showPassword: false,
        passwordStrength: 0,
        
        init() {
            this.checkPasswordStrength();
        },
        
        switchTab(tab) {
            this.activeTab = tab;
        },
        
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
        
        checkPasswordStrength() {
            const password = this.$refs.password?.value || '';
            let strength = 0;
            
            // Check length
            if (password.length >= 8) strength++;
            // Check uppercase
            if (/[A-Z]/.test(password)) strength++;
            // Check lowercase  
            if (/[a-z]/.test(password)) strength++;
            // Check numbers
            if (/\d/.test(password)) strength++;
            // Check special characters
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
            
            this.passwordStrength = strength;
        },
        
        getPasswordStrengthText() {
            const texts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
            return texts[this.passwordStrength] || 'Very Weak';
        },
        
        getPasswordStrengthColor() {
            const colors = ['red', 'orange', 'yellow', 'blue', 'green'];
            return colors[this.passwordStrength] || 'red';
        },
        
        async submitForm(form) {
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
            `;
            
            try {
                // Submit form normally - let Laravel handle it
                form.submit();
            } catch (error) {
                // Restore button state on error
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                console.error('Form submission error:', error);
            }
        }
    }));
    
    Alpine.data('avatarUploader', () => ({
        preview: null,
        
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.preview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        
        removePreview() {
            this.preview = null;
            this.$refs.fileInput.value = '';
        }
    }));
});

// Utility functions
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling?.querySelector('svg');
    
    if (field.type === 'password') {
        field.type = 'text';
        // Change icon to "hide" icon
        if (button) {
            button.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
            `;
        }
    } else {
        field.type = 'password';
        // Change icon back to "show" icon
        if (button) {
            button.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }
}

// Auto-save functionality (optional)
function setupAutoSave() {
    const forms = document.querySelectorAll('form[data-auto-save]');
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', debounce(() => {
                // Save to localStorage
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                localStorage.setItem(`form_${form.id}`, JSON.stringify(data));
            }, 500));
        });
    });
}

// Debounce utility
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    setupAutoSave();
});
