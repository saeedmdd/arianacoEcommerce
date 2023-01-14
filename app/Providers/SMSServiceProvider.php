<?php

namespace App\Providers;

use App\Services\SMS\Kavenegar\Kavenegar;
use App\Services\SMS\MelliPayamak\MelliPayamak;
use App\Services\SMS\SMSServiceInterface;
use Illuminate\Support\ServiceProvider;
use Exception;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(SMSServiceInterface::class, function ($app) {
            if (config('sms.sms-driver') === 'kavengar')
                return new Kavenegar();
            if (config('sms.sms-driver') === 'melli-payamak')
                return new MelliPayamak();
            throw new Exception("The sms provider is not valid");
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
