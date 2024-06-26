<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\FoundPet;
use App\Models\LostPet;
use App\Policies\FoundPetPolicy;
use App\Policies\LostPetPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        FoundPet::class => FoundPetPolicy::class,
        LostPet::class => LostPetPolicy::class
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
