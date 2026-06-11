<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;

class FrontendController extends Controller
{
    public function spa()
    {
        $setting = SettingRepository::query()->first();

        if ($setting?->frontend_coming_soon) {
            return view('comingsoon', [
                'setting' => $setting,
            ]);
        }

        $app_setting = [
            'name' => config('app.name', 'Laravel'),
            'favicon' => $setting?->faviconPath ?? asset('assets/images/favicon.ico'),
        ];

        return view('website', compact('app_setting'));
    }
}
