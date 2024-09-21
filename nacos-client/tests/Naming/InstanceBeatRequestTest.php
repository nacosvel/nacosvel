<?php

namespace Test\Naming;

use Nacosvel\NacosClient\Naming\InstanceBeatRequest;
use Nacosvel\NacosClient\Naming\RegisterInstanceRequest;
use Test\TestCase;

class InstanceBeatRequestTest extends TestCase
{
    public function testInstanceBeatV1()
    {
        $register         = new RegisterInstanceRequest();
        $registerInstance = $register->v1('order', '127.0.0.1', '8111');
        $registerResponse = $this->nacosService->execute($registerInstance);
        var_dump($registerResponse->response());

        $request  = new InstanceBeatRequest();
        $instance = $request->v1('order', '127.0.0.1', '8111', '{"status":"ok"}');
        $response = $this->nacosService->execute($instance);
        var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }
}
