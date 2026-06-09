<?php

namespace App\Providers;

use App\Repositories\GeneralSettingRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()->ip() != '127.0.0.1') {
            Schema::defaultStringLength(191);
        }

        // Share app_setting with all views
        View::composer('*', function ($view) {
            $setting = SettingRepository::query()->first();
            $app_setting = [
                'name' => $setting?->name ?? config('app.name', 'Laravel'),
                'favicon' => $setting?->faviconPath ?? asset('assets/images/favicon.ico'),
                'logo' => $setting?->logoPath ?? asset('assets/images/logo-new.png'),
                'currency_symbol' => $setting?->currency_symbol ?? '$',
                'currency_position' => $setting?->currency_position ?? 'Left',
                'footer_text' => $setting?->footer_text ?? '© 2026 All Rights Reserved',
            ];
            $view->with('app_setting', $app_setting);

            // Determine layout path based on organization domain
            $host = request()->getSchemeAndHttpHost();
            $organization = OrganizationRepository::query()->where('domain', $host)->first();
            
            // If organization exists and user is accessing from org domain, use org layout
            // Otherwise use default admin layout
            $layout_path = $organization ? 'organization.layouts.app' : 'layouts.app';
            $view->with('layout_path', $layout_path);

            // Check if storage link exists
            $storageLink = !file_exists(public_path('storage'));
            $view->with('storageLink', $storageLink);

            // Load notification messages for authenticated users
            if (Auth::check()) {
                $notificationMessages = Auth::user()->notificationInstances()
                    ->with('notification')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
                $view->with('notificationMessages', $notificationMessages);
            } else {
                $view->with('notificationMessages', collect([]));
            }

            // Load available languages
            $languages = LanguageRepository::query()->get();
            $view->with('languages', $languages);
        });
    }
}
