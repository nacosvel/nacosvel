<?php

namespace Nacosvel\Nacos\Contracts;

use Psr\Http\Message\ResponseInterface;

interface NacosResponseInterface
{
    public function __invoke(ResponseInterface $response);

}
