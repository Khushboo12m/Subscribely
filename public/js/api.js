/**
 * API Helper for Subscribely
 * Handles authenticated API requests with Sanctum tokens
 */

const API = {
    baseURL: '/api',
    
    /**
     * Get authentication token from localStorage
     */
    getToken() {
        return localStorage.getItem('token');
    },
    
    /**
     * Check if user is authenticated
     */
    isAuthenticated() {
        return !!this.getToken();
    },
    
    /**
     * Get headers for API requests
     */
    getHeaders(includeAuth = true) {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };
        
        if (includeAuth && this.getToken()) {
            headers['Authorization'] = `Bearer ${this.getToken()}`;
        }
        
        return headers;
    },
    
    /**
     * Make an API request
     * @param {string} endpoint - API endpoint (e.g., '/login', '/dashboard/summary')
     * @param {string} method - HTTP method (GET, POST, PUT, DELETE, etc.)
     * @param {object} data - Request body data (optional)
     * @param {boolean} requireAuth - Whether authentication token is required
     * @returns {Promise} - Response promise
     */
    async request(endpoint, method = 'GET', data = null, requireAuth = true) {
        const url = `${this.baseURL}${endpoint}`;
        const options = {
            method: method,
            headers: this.getHeaders(requireAuth)
        };
        
        if (data && (method !== 'GET' && method !== 'HEAD')) {
            options.body = JSON.stringify(data);
        }
        
        try {
            const response = await fetch(url, options);
            const responseData = await response.json();
            
            // Handle 401 Unauthorized - token expired or invalid
            if (response.status === 401 && requireAuth) {
                this.handleUnauthorized();
                return { error: true, message: 'Unauthorized', data: responseData };
            }
            
            return {
                success: response.ok,
                status: response.status,
                data: responseData,
                error: !response.ok
            };
        } catch (error) {
            console.error('API Request Error:', error);
            return {
                success: false,
                error: true,
                message: 'Network error. Please check your connection.',
                data: null
            };
        }
    },
    
    /**
     * Handle unauthorized access (token expired/invalid)
     */
    handleUnauthorized() {
        localStorage.removeItem('token');
        localStorage.removeItem('token_type');
        
        // Show notification if SweetAlert2 is available
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Session Expired',
                text: 'Please login again.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '/login';
            });
        } else {
            window.location.href = '/login';
        }
    },
    
    /**
     * Login user
     */
    async login(email, password) {
        return await this.request('/login', 'POST', { email, password }, false);
    },
    
    /**
     * Register user
     */
    async register(name, email, password, password_confirmation) {
        return await this.request('/register', 'POST', {
            name,
            email,
            password,
            password_confirmation
        }, false);
    },
    
    /**
     * Logout user
     */
    async logout() {
        const result = await this.request('/logout', 'POST', null, true);
        if (result.success) {
            localStorage.removeItem('token');
            localStorage.removeItem('token_type');
        }
        return result;
    },
    
    /**
     * Get user profile
     */
    async getProfile() {
        return await this.request('/profile', 'GET', null, true);
    },
    
    /**
     * Update user profile
     */
    async updateProfile(name, email, password = null) {
        const data = { name, email };
        if (password) {
            data.password = password;
        }
        return await this.request('/update-profile', 'POST', data, true);
    },

    // Dashboard endpoints
    async getDashboardSummary() {
        return await this.request('/dashboard/summary', 'GET', null, true);
    },
    async getUpcomingRenewals() {
        return await this.request('/dashboard/upcoming', 'GET', null, true);
    },
    async getMonthlyTotals() {
        return await this.request('/dashboard/monthly', 'GET', null, true);
    },

    // Subscriptions CRUD
    async listSubscriptions() {
        return await this.request('/subscriptions', 'GET', null, true);
    },
    async getSubscription(id) {
        return await this.request(`/subscriptions/${id}`, 'GET', null, true);
    },
    async createSubscription(payload) {
        return await this.request('/subscriptions', 'POST', payload, true);
    },
    async updateSubscription(id, payload) {
        return await this.request(`/subscriptions/${id}`, 'PUT', payload, true);
    },
    async deleteSubscription(id) {
        return await this.request(`/subscriptions/${id}`, 'DELETE', null, true);
    },

    async getCategories() {
    return await this.request('/subscription-categories', 'GET', null, true);
    }
};

// Make API available globally
window.API = API;

