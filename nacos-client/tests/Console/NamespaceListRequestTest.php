<?php

namespace Test\Console;

use Nacosvel\NacosClient\Console\NamespaceListRequest;
use Test\TestCase;

class NamespaceListRequestTest extends TestCase
{
    /**
     * 查询命名空间列表v1
     *
     * @return void
     */
    public function testNamespaceListRequestV1(): void
    {
        $request  = new NamespaceListRequest();
        $instance = $request->v1();
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 200);
    }

    /**
     * 查询命名空间列表v2
     *
     * @return void
     */
    public function testNamespaceListRequestV2(): void
    {
        $request  = new NamespaceListRequest();
        $instance = $request->v2();
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

}
