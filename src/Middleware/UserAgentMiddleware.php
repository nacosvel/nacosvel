<?php

namespace Nacosvel\Feign\Middleware;

use Psr\Http\Message\RequestInterface;

class UserAgentMiddleware extends AbstractMiddleware
{
    public function request(RequestInterface $request, array $options): RequestInterface
    {
        return $request->withAddedHeader('user-agent', 'nacosvel/feign');
    }

}
