<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // Importa la clase Gate para definir políticas de autorización
use App\Models\Repository;
use App\Policies\RepositoryPolicy;

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
        // Define la política de autorización para el modelo Repository
        Gate::policy(Repository::class, RepositoryPolicy::class);
    }
}
