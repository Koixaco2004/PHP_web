<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        // Share categories with specific views for navigation
        View::composer(['layouts.app', 'home', 'posts.*'], function ($view) {
            $navigationCategories = Category::active()
                ->withCount(['posts' => function ($query) {
                    $query->published();
                }])
                ->ordered()
                ->get();
            
            $categories = Category::active()->orderBy('name')->get();
            
            $view->with('navigationCategories', $navigationCategories);
            $view->with('categories', $categories);
        });
    }
}
