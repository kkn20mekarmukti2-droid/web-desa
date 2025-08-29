/**
 * Admin Modern UI Utilities
 * Global functions for modern admin interface
 */

// Toast Notification System
function showToast(message, type = 'info', duration = 4000) {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    
    // Set icon based on type
    let icon = '';
    switch(type) {
        case 'success':
            icon = 'fas fa-check-circle';
            break;
        case 'error':
            icon = 'fas fa-exclamation-circle';
            break;
        case 'warning':
            icon = 'fas fa-exclamation-triangle';
            break;
        default:
            icon = 'fas fa-info-circle';
    }
    
    toast.innerHTML = `
        <div class="toast-content">
            <i class="${icon} toast-icon"></i>
            <span class="toast-message">${message}</span>
            <button type="button" class="toast-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(toast);
    
    // Show with animation
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        if (document.body.contains(toast)) {
            toast.classList.remove('show');
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    toast.remove();
                }
            }, 300);
        }
    }, duration);
}

// Loading Overlay
function showLoading(message = 'Loading...') {
    const loading = document.createElement('div');
    loading.id = 'loadingOverlay';
    loading.className = 'loading-overlay';
    loading.innerHTML = `
        <div class="loading-content">
            <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="loading-text">${message}</div>
        </div>
    `;
    
    document.body.appendChild(loading);
    
    // Show with animation
    setTimeout(() => {
        loading.classList.add('show');
    }, 50);
}

function hideLoading() {
    const loading = document.getElementById('loadingOverlay');
    if (loading) {
        loading.classList.remove('show');
        setTimeout(() => {
            if (document.body.contains(loading)) {
                loading.remove();
            }
        }, 300);
    }
}

// Confirmation Dialog
function showConfirm(message, title = 'Konfirmasi', onConfirm = null, onCancel = null) {
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'confirmModal';
    modal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">${title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            <i class="fas fa-question-circle fa-2x text-warning"></i>
                        </div>
                        <div>
                            <p class="mb-0">${message}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmBtn">Confirm</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
    
    // Handle confirm
    document.getElementById('confirmBtn').addEventListener('click', function() {
        bsModal.hide();
        if (onConfirm && typeof onConfirm === 'function') {
            onConfirm();
        }
    });
    
    // Handle cancel
    modal.addEventListener('hidden.bs.modal', function() {
        if (onCancel && typeof onCancel === 'function') {
            onCancel();
        }
        modal.remove();
    });
}

// Image Preview Utility
function previewImage(file, targetElement) {
    if (!file || !file.type.startsWith('image/')) {
        return false;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        if (typeof targetElement === 'string') {
            document.getElementById(targetElement).innerHTML = 
                `<img src="${e.target.result}" alt="Preview" style="width:100%;height:100%;object-fit:cover;border-radius:6px;">`;
        } else if (targetElement instanceof HTMLElement) {
            targetElement.innerHTML = 
                `<img src="${e.target.result}" alt="Preview" style="width:100%;height:100%;object-fit:cover;border-radius:6px;">`;
        }
    };
    reader.readAsDataURL(file);
    return true;
}

// Format File Size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Copy to Clipboard
function copyToClipboard(text, successMessage = 'Copied to clipboard!') {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            showToast(successMessage, 'success');
        }).catch(() => {
            fallbackCopyToClipboard(text, successMessage);
        });
    } else {
        fallbackCopyToClipboard(text, successMessage);
    }
}

function fallbackCopyToClipboard(text, successMessage) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        showToast(successMessage, 'success');
    } catch (err) {
        showToast('Failed to copy to clipboard', 'error');
    }
    
    document.body.removeChild(textArea);
}

// Debounce Function
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            timeout = null;
            if (!immediate) func(...args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func(...args);
    };
}

// Auto-save functionality
class AutoSave {
    constructor(formSelector, saveUrl, interval = 30000) {
        this.form = document.querySelector(formSelector);
        this.saveUrl = saveUrl;
        this.interval = interval;
        this.lastSaved = null;
        this.isDirty = false;
        this.timer = null;
        
        if (this.form) {
            this.init();
        }
    }
    
    init() {
        // Track form changes
        this.form.addEventListener('input', () => {
            this.isDirty = true;
            this.resetTimer();
        });
        
        // Handle form submission
        this.form.addEventListener('submit', () => {
            this.clearTimer();
            this.isDirty = false;
        });
        
        // Start auto-save timer
        this.resetTimer();
    }
    
    resetTimer() {
        this.clearTimer();
        this.timer = setTimeout(() => {
            if (this.isDirty) {
                this.save();
            }
        }, this.interval);
    }
    
    clearTimer() {
        if (this.timer) {
            clearTimeout(this.timer);
            this.timer = null;
        }
    }
    
    async save() {
        if (!this.isDirty) return;
        
        try {
            const formData = new FormData(this.form);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('auto_save', '1');
            
            const response = await fetch(this.saveUrl, {
                method: 'POST',
                body: formData
            });
            
            if (response.ok) {
                this.isDirty = false;
                this.lastSaved = new Date();
                showToast('Auto-saved successfully', 'success', 2000);
            } else {
                throw new Error('Auto-save failed');
            }
        } catch (error) {
            console.error('Auto-save error:', error);
            showToast('Auto-save failed', 'warning', 2000);
        }
        
        this.resetTimer();
    }
    
    destroy() {
        this.clearTimer();
    }
}

// Global Error Handler
window.addEventListener('error', function(e) {
    console.error('Global error:', e.error);
    showToast('An unexpected error occurred', 'error');
});

// Global Unhandled Promise Rejection Handler  
window.addEventListener('unhandledrejection', function(e) {
    console.error('Unhandled promise rejection:', e.reason);
    showToast('An unexpected error occurred', 'error');
});

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, 5000);
    });
    
    // Initialize tooltips globally
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'));
    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        if (!tooltipTriggerEl.hasAttribute('data-bs-toggle')) {
            tooltipTriggerEl.setAttribute('data-bs-toggle', 'tooltip');
        }
        new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover'
        });
    });
    
    // Global keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // ESC key to close modals
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal.show');
            modals.forEach(modal => {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            });
        }
        
        // Ctrl+S to save (prevent default browser save)
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            const form = document.querySelector('form[data-save-shortcut]');
            if (form) {
                form.requestSubmit();
            }
        }
    });
    
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea[data-auto-resize]');
    textareas.forEach(textarea => {
        const resize = () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        };
        
        textarea.addEventListener('input', resize);
        resize(); // Initial resize
    });
    
    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
