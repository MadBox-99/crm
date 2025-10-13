<?php

declare(strict_types=1);

namespace App\Providers;

use App\Filament\Commands\FileGenerators\Resources\ResourceClassGenerator;
use App\Models\Customer;
use App\Models\User;
use Filament\Commands\FileGenerators\Resources\ResourceClassGenerator as BaseResourceClassGenerator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
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
        $this->app->bind(BaseResourceClassGenerator::class, ResourceClassGenerator::class);
        Relation::enforceMorphMap([
            'user' => User::class,
            'customer' => Customer::class,
        ]);
    }
}
