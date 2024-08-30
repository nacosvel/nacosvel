<?php

namespace Test\Config;

use Nacosvel\NacosClient\Config\ListenerConfigRequest;
use Test\TestCase;

class ListenerConfigRequestTest extends TestCase
{
    public function testListenerConfigV1Success()
    {
        $request  = new ListenerConfigRequest();
        $instance = $request->v1('foo', 'bar', 'C:\Users\89234\Desktop\image\foosuccess.txt');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

    public function testListenerConfigV1Error()
    {
        $request  = new ListenerConfigRequest();
        $instance = $request->v1('foo', 'bar', 'C:\Users\89234\Desktop\image\fooerror.txt');
        $response = $this->nacosService->execute($instance);
        var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 200);
    }
}
