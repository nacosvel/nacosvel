<?php

namespace Nacosvel\Feign\Configuration;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use Nacosvel\Feign\Contracts\ClientInterface;

class Client implements ClientInterface
{
    public function __invoke(): HttpClientInterface
    {
        return new HttpClient();
    }

}
