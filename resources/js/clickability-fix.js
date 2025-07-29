// Global fix for mouse click issues
(function() {
    'use strict';
    
    // Function to fix clickability issues
    function fixClickability() {
        console.log('Fixing clickability issues...');
        
        // Get all potentially clickable elements
        const selectors = [
            'button',
            'a',
            '[role="button"]',
            'input[type="button"]',
            'input[type="submit"]',
            'input[type="reset"]',
            '[onclick]',
            '[x-on\\:click]',
            '[\\@click]',
            '.btn-primary',
            '.btn-secondary', 
            '.btn-success',
            '.btn-danger',
            '.clickable'
        ];
        
        selectors.forEach(selector => {
            try {
                const elements = document.querySelectorAll(selector);
                elements.forEach(element => {
                    // Force clickable styles
                    element.style.pointerEvents = 'auto';
                    element.style.cursor = 'pointer';
                    element.style.userSelect = 'none';
                    element.style.webkitUserSelect = 'none';
                    element.style.mozUserSelect = 'none';
                    element.style.msUserSelect = 'none';
                    element.style.touchAction = 'manipulation';
                    element.style.webkitTouchCallout = 'none';
                    element.style.webkitTapHighlightColor = 'transparent';
                    
                    // Add data attribute to track
                    element.setAttribute('data-clickable-fixed', 'true');
                    
                    // Add click event listener if none exists
                    if (!element.hasAttribute('data-click-listener')) {
                        element.addEventListener('click', function(e) {
                            console.log('Click detected on:', this.tagName, this.textContent?.trim());
                        }, { passive: false });
                        element.setAttribute('data-click-listener', 'true');
                    }
                    
                    // Add visual feedback
                    element.addEventListener('mousedown', function() {
                        this.style.transform = 'scale(0.95)';
                    });
                    
                    element.addEventListener('mouseup', function() {
                        this.style.transform = 'scale(1)';
                    });
                    
                    element.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1)';
                    });
                });
                
                console.log(`Fixed ${elements.length} elements with selector: ${selector}`);
            } catch (e) {
                console.warn(`Error fixing selector ${selector}:`, e);
            }
        });
    }
    
    // Function to remove potential blocking overlays
    function removeBlockingOverlays() {
        console.log('Removing potential blocking overlays...');
        
        // Remove any invisible overlays that might block clicks
        const potentialBlockers = document.querySelectorAll('*');
        potentialBlockers.forEach(element => {
            const styles = window.getComputedStyle(element);
            
            // Check for invisible but blocking elements
            if (styles.position === 'fixed' || styles.position === 'absolute') {
                if (styles.opacity === '0' || styles.visibility === 'hidden') {
                    if (styles.pointerEvents !== 'none') {
                        element.style.pointerEvents = 'none';
                        console.log('Fixed blocking overlay:', element);
                    }
                }
            }
        });
    }
    
    // Function to fix form elements
    function fixFormElements() {
        console.log('Fixing form elements...');
        
        const formElements = document.querySelectorAll('input, textarea, select, button');
        formElements.forEach(element => {
            if (element.type === 'text' || element.type === 'email' || element.type === 'password' || element.tagName === 'TEXTAREA' || element.tagName === 'SELECT') {
                element.style.cursor = 'text';
            } else if (element.type === 'button' || element.type === 'submit' || element.tagName === 'BUTTON') {
                element.style.cursor = 'pointer';
                element.style.pointerEvents = 'auto';
            }
        });
    }
    
    // Initialize fixes
    function initializeFixes() {
        fixClickability();
        removeBlockingOverlays();
        fixFormElements();
    }
    
    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeFixes);
    } else {
        initializeFixes();
    }
    
    // Re-run fixes when Alpine.js initializes or updates
    document.addEventListener('alpine:init', initializeFixes);
    document.addEventListener('alpine:initialized', initializeFixes);
    
    // Re-run fixes periodically in case of dynamic content
    setInterval(initializeFixes, 2000);
    
    // Watch for new elements being added
    if (window.MutationObserver) {
        const observer = new MutationObserver(function(mutations) {
            let needsFix = false;
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    needsFix = true;
                }
            });
            
            if (needsFix) {
                setTimeout(initializeFixes, 100);
            }
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    // Debug function - global access
    window.debugClickability = function() {
        console.log('=== Clickability Debug Info ===');
        const clickableElements = document.querySelectorAll('[data-clickable-fixed="true"]');
        console.log(`Total fixed elements: ${clickableElements.length}`);
        
        clickableElements.forEach((el, index) => {
            const styles = window.getComputedStyle(el);
            console.log(`Element ${index + 1}:`, {
                tagName: el.tagName,
                text: el.textContent?.trim(),
                pointerEvents: styles.pointerEvents,
                cursor: styles.cursor,
                zIndex: styles.zIndex,
                position: styles.position
            });
        });
    };
    
    console.log('Global clickability fix loaded');
})();
