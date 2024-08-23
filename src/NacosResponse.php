<?php

namespace Nacosvel\Nacos;

use InvalidArgumentException;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Psr\Http\Message\ResponseInterface;

class NacosResponse implements NacosResponseInterface
{
    public function __invoke(ResponseInterface $response): array
    {
        $content = json_decode($response->getBody()->getContents(), true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new InvalidArgumentException(json_last_error_msg(), -1);
        }

        return $content;
    }

}
