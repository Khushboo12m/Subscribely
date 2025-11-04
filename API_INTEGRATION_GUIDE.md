# API Integration Guide for Blade Views

This guide explains how to connect your Blade views with your existing API endpoints.

## Overview

Your project uses **Laravel Sanctum** for API authentication. The authentication flow works as follows:

1. User submits login/register form in Blade view
2. JavaScript sends request to API endpoint (`/api/login` or `/api/register`)
3. API returns a token (`access_token`)
4. Token is stored in `localStorage`
5. Token is used for subsequent authenticated API calls

## How It Works

### 1. Login Flow

**Blade View**: `resources/views/frontend/auth/login.blade.php`
- Form submits to `{{ route('api.login') }}` (which resolves to `/api/login`)
- Uses `fetch()` API to make POST request
- Stores token in `localStorage.setItem('token', data.access_token)`
- Redirects to `/dashboard` on success

**API Endpoint**: `POST /api/login`
- Returns: `{ message, access_token, token_type }`

### 2. Register Flow

**Blade View**: `resources/views/frontend/auth/register.blade.php`
- Form submits to `{{ route('api.register') }}` (which resolves to `/api/register`)
- Uses `fetch()` API to make POST request
- Stores token in `localStorage.setItem('token', data.access_token)`
- Redirects to `/dashboard` on success

**API Endpoint**: `POST /api/register`
- Returns: `{ message, access_token, token_type }`

## Making Authenticated API Calls

### Option 1: Using the API Helper (Recommended)

Include the helper script in your Blade views:

```html
<script src="{{ asset('js/api.js') }}"></script>
```

Then use it:

```javascript
// Login
const result = await API.login(email, password);
if (result.success && result.data.access_token) {
    localStorage.setItem('token', result.data.access_token);
    window.location.href = '/dashboard';
}

// Get profile
const profile = await API.getProfile();
if (profile.success) {
    console.log(profile.data);
}

// Make custom API call
const subscriptions = await API.request('/subscriptions', 'GET');
```

### Option 2: Using fetch() Directly

```javascript
const token = localStorage.getItem('token');

const response = await fetch('/api/subscriptions', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
    }
});

const data = await response.json();
```

## API Endpoints Reference

### Public Endpoints (No Auth Required)
- `POST /api/register` - Register new user
- `POST /api/login` - Login user
- `POST /api/forgot-password` - Request password reset
- `POST /api/verify-otp` - Verify OTP
- `POST /api/reset-password` - Reset password

### Protected Endpoints (Requires Auth Token)
- `POST /api/logout` - Logout user
- `GET /api/profile` - Get user profile
- `POST /api/update-profile` - Update user profile
- `GET /api/subscriptions` - List subscriptions
- `POST /api/subscriptions` - Create subscription
- `GET /api/subscriptions/{id}` - Get subscription
- `PUT /api/subscriptions/{id}` - Update subscription
- `DELETE /api/subscriptions/{id}` - Delete subscription
- `GET /api/dashboard/summary` - Dashboard summary
- `GET /api/dashboard/upcoming` - Upcoming renewals
- `GET /api/dashboard/monthly` - Monthly totals

## Error Handling

The API returns validation errors in this format:

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field is required."]
    }
}
```

Handle errors in your JavaScript:

```javascript
if (result.error) {
    if (result.data.errors) {
        // Laravel validation errors
        const errorMessages = Object.values(result.data.errors).flat();
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errorMessages.join('<br>')
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: result.data.message || 'An error occurred'
        });
    }
}
```

## Token Management

### Store Token
```javascript
localStorage.setItem('token', token);
```

### Get Token
```javascript
const token = localStorage.getItem('token');
```

### Check if Authenticated
```javascript
const isAuthenticated = !!localStorage.getItem('token');
```

### Remove Token (Logout)
```javascript
localStorage.removeItem('token');
localStorage.removeItem('token_type');
```

## Example: Complete Login Implementation

```javascript
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    const result = await API.login(email, password);
    
    if (result.success && result.data.access_token) {
        localStorage.setItem('token', result.data.access_token);
        Swal.fire({
            icon: 'success',
            title: 'Login Successful!',
            timer: 1500,
            showConfirmButton: false
        });
        setTimeout(() => {
            window.location.href = '/dashboard';
        }, 1500);
    } else {
        // Handle errors
        let errorMessage = 'Login failed!';
        if (result.data.errors) {
            errorMessage = Object.values(result.data.errors).flat().join('<br>');
        } else if (result.data.message) {
            errorMessage = result.data.message;
        }
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            html: errorMessage
        });
    }
});
```

## Protecting Blade Views

Since tokens are stored in `localStorage` (not sent automatically with page requests), protected Blade views should check authentication in JavaScript.

### Option 1: Simple Auth Check (Recommended)

Include the auth check script in your protected Blade views:

```html
<!-- At the top of your Blade view, before any content -->
<script src="{{ asset('js/auth-check.js') }}"></script>
```

This will automatically redirect to `/login` if no token is found.

### Option 2: Manual Auth Check

```javascript
// Check if user is authenticated
const token = localStorage.getItem('token');
if (!token) {
    window.location.href = '/login';
    return;
}

// Rest of your page code...
```

### Example: Protected Dashboard View

```html
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <!-- Auth check - redirects if not authenticated -->
    <script src="{{ asset('js/auth-check.js') }}"></script>
    
    <!-- API helper for making authenticated calls -->
    <script src="{{ asset('js/api.js') }}"></script>
    
    <div id="dashboard-content">
        <!-- Dashboard content will be loaded here -->
    </div>
    
    <script>
        // Load dashboard data
        async function loadDashboard() {
            const result = await API.request('/dashboard/summary', 'GET');
            if (result.success) {
                // Display data
                document.getElementById('dashboard-content').innerHTML = 
                    JSON.stringify(result.data);
            } else {
                console.error('Failed to load dashboard:', result.data);
            }
        }
        
        loadDashboard();
    </script>
</body>
</html>
```

## Next Steps

1. ✅ Login and Register are connected
2. ✅ Auth check helper created (`public/js/auth-check.js`)
3. ✅ API helper created (`public/js/api.js`)
4. Next: Connect Dashboard page to fetch data from `/api/dashboard/summary`
5. Next: Connect Subscriptions page to CRUD endpoints
6. Next: Connect Profile page to profile endpoints

## Notes

- CSRF tokens are exempted for `/api/*` routes (see `app/Http/Middleware/VerifyCsrfToken.php`)
- Tokens are stored in `localStorage` (survives page refreshes)
- Protected API endpoints require `Authorization: Bearer {token}` header
- Token expires based on Sanctum configuration (default: never expires)

