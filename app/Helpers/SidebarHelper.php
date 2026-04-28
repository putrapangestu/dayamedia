<?php

if (! function_exists('isActiveRoute')) {
    /**
     * Check if current route matches given route pattern
     *
     * @param  string|array  $routes
     */
    function isActiveRoute($routes, string $className = 'active'): string
    {
        $currentRoute = Route::currentRouteName();

        if (is_array($routes)) {
            foreach ($routes as $route) {
                if (Route::is($route)) {
                    return $className;
                }
            }

            return '';
        }

        return Route::is($routes) ? $className : '';
    }
}

if (! function_exists('isActiveUrl')) {
    /**
     * Check if current URL matches given URL pattern
     *
     * @param  string|array  $urls
     */
    function isActiveUrl($urls, string $className = 'active'): string
    {
        $currentUrl = request()->url();

        if (is_array($urls)) {
            foreach ($urls as $url) {
                if (str_contains($currentUrl, $url)) {
                    return $className;
                }
            }

            return '';
        }

        return str_contains($currentUrl, $url) ? $className : '';
    }
}

if (! function_exists('getAdminMenuState')) {
    /**
     * Get menu state for admin sidebar
     */
    function getAdminMenuState(): array
    {
        $currentRoute = Route::currentRouteName();

        return [
            'dashboard' => Route::is('admin.home') ? 'active' : '',
            'master_data' => Route::is('admin.category.*') ? 'active' : '',
            'affiliate_level' => Route::is('admin.affiliate-order.*') ? 'active' : '',
            'promo' => Route::is('admin.promo.*') ? 'active' : '',
            'books' => Route::is('admin.book.*') ? 'active' : '',
            'members' => Route::is('admin.member.*') ? 'active' : '',
            'editor' => Route::is('admin.editor.*') || Route::is('admin.book-editor.*') ? 'active' : '',
            'orders' => Route::is('admin.book-order.*') || Route::is('admin.bab-order.*') ? 'active' : '',
            'affiliate' => Route::is('admin.affiliate.*') ? 'active' : '',
            'withdrawal' => Route::is('admin.withdrawl.*') ? 'active' : '',
            'settings' => Route::is('settings.*') ? 'active' : '',
        ];
    }
}
