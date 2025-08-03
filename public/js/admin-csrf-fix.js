// Global CSRF token refresh untuk semua form admin
(function() {
    'use strict';
    
    // Function to get fresh CSRF token
    function refreshCSRFToken() {
        return fetch(window.location.origin + '/admin/dashboard', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newToken = doc.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (newToken) {
                // Update meta tag
                const metaTag = document.querySelector('meta[name="csrf-token"]');
                if (metaTag) {
                    metaTag.setAttribute('content', newToken);
                }
                
                // Update all form tokens
                document.querySelectorAll('input[name="_token"]').forEach(input => {
                    input.value = newToken;
                });
                
                // Update axios default header if exists
                if (window.axios && window.axios.defaults) {
                    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = newToken;
                }
                
                console.log('CSRF token refreshed successfully');
                return newToken;
            }
            throw new Error('No CSRF token found');
        });
    }
    
    // Auto refresh every 30 minutes
    setInterval(refreshCSRFToken, 30 * 60 * 1000);
    
    // Refresh before form submit
    document.addEventListener('submit', function(e) {
        const form = e.target;
        const method = form.method.toLowerCase();
        
        if (['post', 'put', 'patch', 'delete'].includes(method)) {
            e.preventDefault();
            
            refreshCSRFToken()
                .then(() => {
                    // Re-submit form after token refresh
                    form.submit();
                })
                .catch(error => {
                    console.error('Failed to refresh CSRF token:', error);
                    // Continue with original submit
                    form.submit();
                });
        }
    });
    
    // Handle AJAX requests
    document.addEventListener('DOMContentLoaded', function() {
        // Setup axios interceptor if available
        if (window.axios) {
            window.axios.interceptors.response.use(
                response => response,
                error => {
                    if (error.response && error.response.status === 419) {
                        console.warn('419 CSRF error detected, refreshing token...');
                        return refreshCSRFToken().then(() => {
                            // Retry the original request
                            const config = error.config;
                            config.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            return window.axios.request(config);
                        });
                    }
                    return Promise.reject(error);
                }
            );
        }
    });
    
    // Session warning before expiry
    const sessionLifetime = 7200 * 1000; // 2 hours in milliseconds
    const warningTime = sessionLifetime - (10 * 60 * 1000); // Warn 10 minutes before
    
    setTimeout(function() {
        if (confirm('Your session will expire in 10 minutes. Click OK to extend your session.')) {
            refreshCSRFToken();
        }
    }, warningTime);
    
})();
