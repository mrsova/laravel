<?php

namespace App\Providers;

use App\Comments;
use Illuminate\Support\ServiceProvider;
use App\Post;
use App\Category;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //появляется до рендеринга вызываем  метод и вьюху в коротру данные передаем в колбеке запросы и переменные которые передаем
        view()->composer('front._sidebar', function($view){
            $view->with('popularPosts', Post::getPopularPosts());
            $view->with('featuredPosts', Post::getFeaturedPosts());
            $view->with('recentPosts', Post::getRecentPosts());
            $view->with('categories', Category::all());
        });
        //появляется до рендеринга вызываем  метод и вьюху в коротру данные передаем в колбеке запросы и переменные которые передаем
        view()->composer('admin._sidebar', function($view){
            $view->with('newCommentsCount', Comments::where('status',0)->count());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
