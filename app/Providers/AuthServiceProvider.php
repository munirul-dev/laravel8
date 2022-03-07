<?php

namespace App\Providers;

use App\Models\BlogPost;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        BlogPost::class => 'App\Policies\BlogPostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::resource('posts', 'App\Policies\BlogPostPolicy');

        Gate::before(function ($user, $ability) {
            if ($user->is_admin && in_array($ability, ['update', 'delete'])) {
                return true;
            }
        });

        Gate::define('home.secret', function ($user) {
            return $user->is_admin;
        });

        // Gate::define('update-post', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });

        // Gate::define('posts.update', 'App\Policies\PostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\PostPolicy@delete');

        // Gate::after(function ($user, $ability, $results) {
        //     if ($user->isAdmin) {
        //         return true;
        //     }
        // });
    }
}
