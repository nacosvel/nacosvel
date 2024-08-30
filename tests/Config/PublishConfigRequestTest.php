<?php

namespace Test\Config;

use Nacosvel\NacosClient\Config\PublishConfigRequest;
use Test\TestCase;

class PublishConfigRequestTest extends TestCase
{
    protected function tearDown(): void
    {

    }

    public function testPublishConfigV1()
    {
        $request  = new PublishConfigRequest();
        $instance = $request->v1('foo', 'bar', 'foobar');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

    public function testPublishConfigV2()
    {
        $request  = new PublishConfigRequest();
        $instance = $request->v2('foo', 'bar', 'foobar');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

}
