/* MOBILE-FIRST ADMIN JAVASCRIPT */
/* Responsive Admin Panel Controls */

document.addEventListener('DOMContentLoaded', function() {
    initializeAdminMobile();
    initializeResponsiveTables();
    initializeFormEnhancements();
    initializeTouchEnhancements();
});

/* ========================================
   MOBILE SIDEBAR CONTROLS
======================================== */

function initializeAdminMobile() {
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (!sidebar || !sidebarToggle) return;
    
    // Toggle sidebar on mobile
    function toggleSidebar() {
        const isShow = sidebar.classList.contains('show');
        
        if (isShow) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }
    
    // Open sidebar
    function openSidebar() {
        sidebar.classList.add('show');
        if (sidebarOverlay) {
            sidebarOverlay.classList.add('show');
        }
        document.body.style.overflow = 'hidden';
        
        // Focus management for accessibility
        const firstFocusable = sidebar.querySelector('a, button');
        if (firstFocusable) {
            firstFocusable.focus();
        }
    }
    
    // Close sidebar
    function closeSidebar() {
        sidebar.classList.remove('show');
        if (sidebarOverlay) {
            sidebarOverlay.classList.remove('show');
        }
        document.body.style.overflow = '';
        
        // Return focus to toggle button
        if (sidebarToggle) {
            sidebarToggle.focus();
        }
    }
    
    // Event listeners
    sidebarToggle.addEventListener('click', toggleSidebar);
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('show')) {
            closeSidebar();
        }
    });
    
    // Close sidebar when clicking on nav links (mobile only)
    if (window.innerWidth <= 768) {
        const navLinks = sidebar.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                setTimeout(closeSidebar, 100); // Small delay for better UX
            });
        });
    }
    
    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (window.innerWidth >= 768) {
                closeSidebar();
            }
        }, 100);
    });
    
    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchStartY = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
    });
    
    document.addEventListener('touchmove', function(e) {
        if (!touchStartX || !touchStartY) return;
        
        const touchEndX = e.touches[0].clientX;
        const touchEndY = e.touches[0].clientY;
        const diffX = touchStartX - touchEndX;
        const diffY = touchStartY - touchEndY;
        
        // Horizontal swipe detection
        if (Math.abs(diffX) > Math.abs(diffY)) {
            if (diffX > 50 && sidebar.classList.contains('show')) {
                // Swipe left to close sidebar
                closeSidebar();
            } else if (diffX < -50 && !sidebar.classList.contains('show') && touchStartX < 50) {
                // Swipe right from edge to open sidebar
                openSidebar();
            }
        }
        
        touchStartX = 0;
        touchStartY = 0;
    });
}

/* ========================================
   RESPONSIVE TABLES
======================================== */

function initializeResponsiveTables() {
    // Enhanced DataTables for mobile
    if (window.$ && $.fn.DataTable) {
        $('.data-table').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 0,
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            return col.hidden ?
                                '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                '<td class="font-weight-bold">' + col.title + ':' + '</td> ' +
                                '<td>' + col.data + '</td>' +
                                '</tr>' :
                                '';
                        }).join('');
                        
                        return data ? $('<table class="table table-sm"/>').append(data) : false;
                    }
                }
            },
            columnDefs: [{
                className: 'dtr-control',
                orderable: false,
                targets: 0,
                defaultContent: '',
                width: '10px'
            }],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.childRowImmediate,
                        type: ''
                    }
                }
            },
            pageLength: window.innerWidth < 768 ? 10 : 25,
            lengthMenu: window.innerWidth < 768 ? [[5, 10, 15], [5, 10, 15]] : [[10, 25, 50, 100], [10, 25, 50, 100]],
            scrollX: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            initComplete: function() {
                // Mobile-specific table enhancements
                if (window.innerWidth < 768) {
                    this.api().columns().every(function() {
                        var column = this;
                        if (column.index() > 2) { // Hide columns beyond first 3 on mobile
                            column.visible(false);
                        }
                    });
                }
            }
        });
    }
    
    // Manual responsive table enhancement for non-DataTables
    const tables = document.querySelectorAll('.admin-table:not(.dataTable)');
    tables.forEach(function(table) {
        makeTableResponsive(table);
    });
}

function makeTableResponsive(table) {
    const wrapper = document.createElement('div');
    wrapper.className = 'admin-table-responsive';
    table.parentNode.insertBefore(wrapper, table);
    wrapper.appendChild(table);
    
    // Add mobile-specific styling
    if (window.innerWidth < 768) {
        const cells = table.querySelectorAll('td, th');
        cells.forEach(function(cell, index) {
            if (index % 4 > 2) { // Hide every 4th+ column on mobile
                cell.style.display = 'none';
            }
        });
    }
}

/* ========================================
   FORM ENHANCEMENTS
======================================== */

function initializeFormEnhancements() {
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(function(textarea) {
        textarea.style.resize = 'vertical';
        textarea.style.minHeight = '100px';
        
        // Auto-expand on mobile
        if (window.innerWidth < 768) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    });
    
    // Enhanced file inputs for mobile
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(function(input) {
        const wrapper = document.createElement('div');
        wrapper.className = 'mobile-file-input';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        
        const label = document.createElement('label');
        label.className = 'admin-btn admin-btn-outline';
        label.innerHTML = '<i class="fas fa-upload"></i> Pilih File';
        label.setAttribute('for', input.id);
        wrapper.appendChild(label);
        
        const preview = document.createElement('div');
        preview.className = 'file-preview';
        wrapper.appendChild(preview);
        
        input.addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Belum ada file dipilih';
            preview.textContent = fileName;
        });
        
        input.style.display = 'none';
    });
    
    // Form validation feedback
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let hasError = false;
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    hasError = true;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (hasError && window.innerWidth < 768) {
                e.preventDefault();
                // Scroll to first error field on mobile
                const firstError = form.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });
    });
}

/* ========================================
   TOUCH ENHANCEMENTS
======================================== */

function initializeTouchEnhancements() {
    // Add touch feedback to buttons
    const buttons = document.querySelectorAll('.admin-btn, .btn, .nav-link');
    buttons.forEach(function(button) {
        button.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
        });
        
        button.addEventListener('touchend', function() {
            this.style.transform = '';
        });
    });
    
    // Improve dropdown behavior on mobile
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('click', function(e) {
            if (window.innerWidth < 768) {
                e.preventDefault();
                const menu = this.nextElementSibling;
                if (menu && menu.classList.contains('dropdown-menu')) {
                    menu.classList.toggle('show');
                }
            }
        });
    });
    
    // Close dropdowns when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 768 && !e.target.closest('.dropdown')) {
            const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
            openDropdowns.forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
}

/* ========================================
   UTILITIES
======================================== */

// Show loading state for mobile
function showMobileLoading(element) {
    if (window.innerWidth < 768 && element) {
        const spinner = document.createElement('i');
        spinner.className = 'fas fa-spinner fa-spin me-2';
        element.insertBefore(spinner, element.firstChild);
        element.disabled = true;
    }
}

function hideMobileLoading(element) {
    if (element) {
        const spinner = element.querySelector('.fa-spinner');
        if (spinner) {
            spinner.remove();
        }
        element.disabled = false;
    }
}

// Mobile notification
function showMobileNotification(message, type = 'info') {
    if (window.innerWidth < 768) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} mobile-notification`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}-circle me-2"></i>
            ${message}
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(function() {
            notification.remove();
        }, 3000);
    }
}

// Export functions for global use
window.adminMobile = {
    showLoading: showMobileLoading,
    hideLoading: hideMobileLoading,
    showNotification: showMobileNotification
};
