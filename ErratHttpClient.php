<?php
/**
 * Created by pilus <i@pilus.me> at 2021-08-07 15:47.
 */

namespace PoorDev\Errat;

use Facade\FlareClient\Http\Client;
use Illuminate\Support\Str;

class ErratHttpClient extends Client
{
    public function __construct(
        ?string $apiToken,
        ?string $apiSecret,
        string $baseUrl = 'https://report.errat.app',
        int $timeout = 10
    ) {
        if (empty($baseUrl)) {
            $baseUrl = 'https://report.errat.app';
        }

        $baseUrl .= '/p/' . config('flare.errat_project') . '/errors';

        parent::__construct($apiToken, $apiSecret, $baseUrl, $timeout);
    }

    /**
     * @param string $url
     * @param array  $arguments
     *
     * @return array|false
     */
    public function post(string $url, array $arguments = [])
    {
        $arguments['appEnv'] = config('app.env');
        $arguments['appDebug'] = config('app.debug');

        return parent::post($url, $arguments);
    }
}
