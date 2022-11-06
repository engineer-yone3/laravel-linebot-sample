<?php

namespace App\Providers;

use App\Services\Bot\LineApiServiceInterface;
use App\Services\Bot\LineApiServiceStub;
use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LineBotProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LINEBot::class, function () {
            $httpClient = new CurlHTTPClient(config('const.line_token'));
            return new LINEBot($httpClient, ['channelSecret' => config('const.line_secret')]);
        });

        $this->app->bind(LineApiServiceInterface::class, LineApiServiceStub::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $httpClient = new CurlHTTPClient(config('const.line_token'));
        // $this->app->makeWith(LINEBot::class, ['httpClient' => $httpClient, 'args' => ['channelSecret' => config('const.line_secret')]]);
        
    }
}
