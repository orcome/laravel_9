<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Sister' => 'App\Policies\SisterPolicy',
        'App\Models\Brother' => 'App\Policies\BrotherPolicy',
        'App\Models\Mother' => 'App\Policies\MotherPolicy',
        'App\Models\Master' => 'App\Policies\MasterPolicy',
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
