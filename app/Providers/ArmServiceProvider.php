<?php

namespace App\Providers;

use App\Development\Arm;
use Illuminate\Support\ServiceProvider;

class ArmServiceProvider extends ServiceProvider
{
	
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Arm::class', function() {
			return Arm();
		});
    }
}
