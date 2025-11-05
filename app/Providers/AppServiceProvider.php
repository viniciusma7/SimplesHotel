<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TarefaRepositoryInterface;
use App\Repositories\EloquentTarefaRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TarefaRepositoryInterface::class, EloquentTarefaRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
