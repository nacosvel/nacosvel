<?php

namespace Nacosvel\Nacos;

use InvalidArgumentException;
use Nacosvel\Nacos\Concerns\NacosResponseTrait;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Psr\Http\Message\ResponseInterface;

class NacosResponse implements NacosResponseInterface
{
    use NacosResponseTrait;

    /**
     * @param (callable(ResponseInterface): mixed)|null $callback
     *
     * @return mixed
     */
    public function response(callable $callback = null): mixed
    {
        $callback = $callback ?? function (ResponseInterface $response): array {
            $content = json_decode($response->getBody()->getContents(), true);

            if (json_last_error() != JSON_ERROR_NONE) {
                throw new InvalidArgumentException(json_last_error_msg(), -1);
            }

            return $content;
        };

        return $callback($this->getResponse());
    }

}
