/**
 * Authentication Check Helper
 * Include this in protected Blade views to check authentication
 */

(function() {
    // Check if user is authenticated
    const token = localStorage.getItem('token');
    
    if (!token) {
        // No token found, redirect to login
        window.location.href = '/login';
        return;
    }
    
    // Optional: Verify token is still valid by checking profile
    // Uncomment below if you want to verify token validity on page load
    
    /*
    fetch('/api/profile', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (response.status === 401) {
            // Token expired or invalid
            localStorage.removeItem('token');
            localStorage.removeItem('token_type');
            window.location.href = '/login';
        }
        // Token is valid, continue loading page
    })
    .catch(error => {
        console.error('Auth check error:', error);
    });
    */
})();

