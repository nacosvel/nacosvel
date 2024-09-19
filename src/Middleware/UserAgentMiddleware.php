<?php

namespace Nacosvel\Feign\Middleware;

use Psr\Http\Message\RequestInterface;

class UserAgentMiddleware extends RequestMiddleware
{
    public function request(RequestInterface $request, array $options): RequestInterface
    {
        $originalUserAgent = $request->getHeader('User-Agent');
        $request = $request->withoutHeader('User-Agent');
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $key = str_replace('_', '-', substr($key, 5));
                $request = $request->withAddedHeader($key, $value);
            } elseif (in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH', 'CONTENT_MD5'], true)) {
                $request = $request->withAddedHeader($key, $value);
            }
        }
        return $request->withAddedHeader('User-Agent', $originalUserAgent)->withAddedHeader('User-Agent', 'nacosvel/feign');
    }

}
