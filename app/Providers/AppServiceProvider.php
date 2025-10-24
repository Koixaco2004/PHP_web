<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Category;

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
        // Use custom pagination view
        Paginator::defaultView('vendor.pagination.tailwind');

        // Share categories with specific views for navigation
        View::composer(['layouts.app', 'home', 'posts.*'], function ($view) {
            $navigationCategories = Category::active()
                ->withCount(['posts' => function ($query) {
                    $query->published();
                }])
                ->ordered()
                ->get();
            $view->with('navigationCategories', $navigationCategories);
        });
    }
}
