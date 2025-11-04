API & Frontend Integration — Detailed Explanation

This text file explains two things in detail:

1. Why and when to include api.js and auth-check.js in your Blade views
2. Why we added `api/*` to the CSRF exception in VerifyCsrfToken middleware

---

PART A — api.js and auth-check.js (Detailed Explanation)

1. Overview

This project uses an API-first authentication pattern: your Blade pages (frontend) call Laravel API endpoints (routes defined in routes/api.php). After login or registration the API returns a token (Sanctum personal access token), which the frontend stores and then includes in future requests as an Authorization header.

To keep frontend code clean, consistent, and maintainable we add two utility scripts:

• api.js — a centralized API helper
• auth-check.js — a lightweight frontend guard for protected pages

Below is a detailed description of each file, why it's needed, when to include it, and how it works.

---

A. api.js — Central API Request Manager

Purpose
• Centralizes all API request logic (building headers, attaching tokens, parsing responses).
• Automatically includes Authorization header (Bearer token) when required.
• Handles common response cases (success, validation errors, 401 unauthorized, network errors).
• Provides small wrapper functions for login, register, logout, profile, etc., to keep page code concise.

Why use it
• Avoids repeating the same fetch code across many pages.
• When you need to change authentication behavior (e.g., token format, refresh tokens), you change one file.
• Debugging and monitoring API calls becomes easier.

Where to include api.js
• Include on any page that makes API calls (protected or public), for example:

* login.blade.php (optional — login flow can call API directly or via API helper)
* register.blade.php (optional)
* dashboard.blade.php (recommended)
* subscriptions.blade.php (recommended)
* profile.blade.php (recommended)
* any dynamic page that talks to `/api/*`

How api.js works (core concepts)
• baseURL property points at '/api' to simplify endpoint strings.
• getToken(): reads token from localStorage.
• getHeaders(includeAuth = true): returns standard headers and adds `Authorization: Bearer <token>` when includeAuth is true and a token exists.
• request(endpoint, method, data, requireAuth): builds fetch options, sends request, parses JSON, handles HTTP status codes (especially 401), and returns a normalized object `{ success, status, data, error }`.
• handleUnauthorized(): deletes token from storage and redirects to login (used when 401 returned).

Example usage (dashboard page):

```js
// after including api.js
const res = await API.request('/dashboard/summary', 'GET');
if (res.success) {
  // render dashboard
} else if (res.status === 401) {
  // API already handles redirect, but you can also show a message
}
```

Best Practices / Notes
• Always set `Accept: application/json` so Laravel returns JSON errors, not HTML redirects.
• Keep token management single-sourced: store and remove tokens only via the API helper or central functions.
• Consider token refresh logic later if you want short-lived tokens.

Security note
• localStorage is used for simplicity; understand that localStorage tokens are vulnerable to XSS. For production, consider cookie-based (httpOnly) sessions via Sanctum SPA auth or implement refresh tokens & short-lived access tokens.

---

B. auth-check.js — Frontend Page Guard

Purpose
• Ensures that protected Blade views (dashboard, subscriptions) are not visible to unauthenticated users.
• Simple client-side guard: checks whether token exists in localStorage; optionally can verify token validity by calling `/api/profile`.

Where to include auth-check.js
• On protected Blade views only — include it at the top of the page BEFORE other scripts or content to prevent a flash of protected content.

* Example pages: dashboard.blade.php, subscriptions.blade.php, profile.blade.php

Why it is necessary
• Blade views are served by the server and token lives on the client. The server cannot protect those static Blade outputs using the token — the client must check and redirect.
• Without auth-check.js, users could open /dashboard directly and see an empty or broken UI while API calls fail. With auth-check.js, they are redirected to login immediately.

Example content

```js
(function() {
  const token = localStorage.getItem('token');
  if (!token) {
    window.location.href = '/login';
    return;
  }
  // Optionally verify token with /api/profile
})();
```

Best Practices
• Put auth-check.js script tag before the rest of page content so unauthorized users are redirected before any sensitive content is displayed.
• Optionally verify token server-side using `/api/profile` on page load if you want to ensure that the token hasn't been revoked or expired.

---

PART B — Why we added `api/*` to CSRF exclusion (VerifyCsrfToken middleware)

File changed:

`app/Http/Middleware/VerifyCsrfToken.php`

```php
protected $except = [
    'api/*'
];
```

Background on CSRF
• CSRF (Cross-Site Request Forgery) protects browser-based form submissions by ensuring each state-changing request includes a valid CSRF token. This prevents other websites or scripts from forging actions on behalf of the user.

Why CSRF blocks our API calls originally
• Laravel's VerifyCsrfToken middleware is applied to web routes by default. When a POST/PUT/DELETE request reaches the app and lacks a valid CSRF token, Laravel rejects it with "CSRF token mismatch".
• Our frontend uses `fetch()` to send JSON to `/api/*`. These requests are not accompanied by the Blade `@csrf` token (no form token is embedded). So Laravel rejected them.

Why API routes don’t need CSRF
• Our API uses stateless token authentication (Bearer token) rather than relying on the authenticated session cookie. With token-based auth, CSRF is not required because the attacker cannot cause the victim to include a valid Authorization header from another site.
• APIs are consumed by many clients (mobile apps, third-party JS, etc.) where CSRF token injection is not practical.

Why we excluded `api/*`
• To allow JavaScript frontends and external clients to call API routes without CSRF.
• To separate concerns: web forms use CSRF + sessions; APIs use token-based auth.

Security considerations
• Ensure API endpoints require Authorization headers when needed.
• Keep web routes protected by CSRF and use httpOnly cookies when using cookie-based auth.
• Excluding `api/*` does NOT make the API insecure by itself — token-based security must be enforced and tokens must be validated on the server.

---

PART C — Practical tips and checklist

1. Include files only where needed
   • Login/Register pages: include api.js optionally (makes code consistent) but do NOT include auth-check.js.
   • Protected pages: include auth-check.js then include api.js.

2. Fetch best practices
   • Always set Accept header to application/json when calling API endpoints from the browser.
   • Use `credentials: 'same-origin'` only if you require cookies to be sent (not necessary for token-based APIs unless you use cookie-based Sanctum auth).

3. Token lifecycle
   • If you plan to issue short-lived tokens, add refresh tokens and implement auto-refresh in api.js.
   • On logout, call `/api/logout` and remove token from localStorage.

4. Production deployment
   • Use HTTPS
   • Consider cookie-based Sanctum SPA auth for higher security
   • Harden CSP, sanitize inputs to reduce XSS risk, and consider server-side token revocation.


