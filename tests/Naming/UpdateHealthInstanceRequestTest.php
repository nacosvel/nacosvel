<?php

namespace Test\Naming;

use Nacosvel\NacosClient\Naming\RegisterInstanceRequest;
use Nacosvel\NacosClient\Naming\UpdateHealthInstanceRequest;
use Test\TestCase;

class UpdateHealthInstanceRequestTest extends TestCase
{
    public function testUpdateHealthInstanceV1()
    {
        $register         = new RegisterInstanceRequest();
        $registerInstance = $register->v1('order', '127.0.0.1', '8111');
        $registerResponse = $this->nacosService->execute($registerInstance);
        var_dump($registerResponse->response());

        $request  = new UpdateHealthInstanceRequest();
        $instance = $request->v1('order', '127.0.0.1', '8112', true);
        $response = $this->nacosService->execute($instance);
        var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

    public function testUpdateHealthInstanceV2()
    {
        $register         = new RegisterInstanceRequest();
        $registerInstance = $register->v1('order', '127.0.0.1', '8111');
        $registerResponse = $this->nacosService->execute($registerInstance);
        var_dump($registerResponse->response());

        $request  = new UpdateHealthInstanceRequest();
        $instance = $request->v2('order', '127.0.0.1', '8112', true);
        $response = $this->nacosService->execute($instance);
        var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }
}
