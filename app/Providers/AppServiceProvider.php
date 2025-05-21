<?php

namespace App\Providers;
use App\Enums\About\TypeEnum;
use App\Models\Setting\Setting;
use Illuminate\Support\ServiceProvider;
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
        $aboutTypes = TypeEnum::cases();
        $logo = Setting::first()?->getFirstMediaUrl('logo2') ?? null;
        View::share(['aboutTypes' => $aboutTypes, 'logo' => $logo]);
    }
}
