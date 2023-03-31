<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        Passport::tokensCan([
            'read-postulations' => 'Lista de postulaciones',
            'read-jobs' => 'Lista de trabajos',
            'edit-job' => 'Editar trabajo',
            'manage-acount' => 'Obtener informacion de la cuenta',
        ]);
    }
}
