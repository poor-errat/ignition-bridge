<?php
/**
 * Created by pilus <i@pilus.me> at 2021-08-07 15:39.
 */

namespace PoorDev\Errat;

use Facade\FlareClient\Flare;
use PoorDev\Errat\ErratHttpClient;
use Facade\Ignition\Context\LaravelContextDetector;
use Facade\Ignition\IgnitionServiceProvider;

class ErratServiceProvider extends IgnitionServiceProvider
{
    protected function registerFlare()
    {
        $this->app->singleton('flare.http', function () {
            return new ErratHttpClient(
                config('flare.key'),
                config('flare.secret'),
                config('flare.base_url', 'https://report.errat.app')
            );
        });

        $this->app->alias('flare.http', ErratHttpClient::class);

        $this->app->singleton(Flare::class, function () {
            $client = new Flare(
                $this->app->get('flare.http'),
                new LaravelContextDetector,
                $this->app
            );

            $client->applicationPath(base_path());

            $client->stage(config('app.env'));

            return $client;
        });

        return $this;
    }
}
