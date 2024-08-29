<?php

namespace Test\Console;

use Nacosvel\NacosClient\Console\CreateNamespaceRequest;
use Nacosvel\NacosClient\Console\DeleteNamespaceRequest;
use Nacosvel\NacosClient\Console\NamespaceRequest;
use Nacosvel\NacosClient\Console\UpdateNamespaceRequest;
use Test\TestCase;

class NamespaceRequestTest extends TestCase
{
    protected function tearDown(): void
    {
        $request  = new DeleteNamespaceRequest();
        $instance = $request->v2('foo');
        $response = $this->nacosService->execute($instance);
    }

    /**
     * 创建命名空间v1
     *
     * @return void
     */
    public function testCreateNamespaceRequestV1Success(): void
    {
        $request  = new CreateNamespaceRequest();
        $instance = $request->v1('foo', 'bar');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

    /**
     * 创建命名空间v1
     *
     * @return void
     */
    public function testCreateNamespaceRequestV1Error(): void
    {
        $request  = new CreateNamespaceRequest();
        $instance = $request->v1('foo', '');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 22000);
    }

    /**
     * 创建命名空间v2
     *
     * @return void
     */
    public function testCreateNamespaceRequestV2Success(): void
    {
        $request  = new CreateNamespaceRequest();
        $instance = $request->v2('foo', 'bar');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

    /**
     * 创建命名空间v2
     *
     * @return void
     */
    public function testCreateNamespaceRequestV2Error(): void
    {
        $request  = new CreateNamespaceRequest();
        $instance = $request->v2('foo', '');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 22000);
    }

    /**
     * 修改命名空间v1
     *
     * @return void
     */
    public function testUpdateNamespaceRequestV1(): void
    {
        $request  = new UpdateNamespaceRequest();
        $instance = $request->v1('foo', 'bar', 'baz');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

    /**
     * 修改命名空间v2
     *
     * @return void
     */
    public function testUpdateNamespaceRequestV2(): void
    {
        $request  = new UpdateNamespaceRequest();
        $instance = $request->v2('foo', 'bar')->setNamespaceDesc('baz');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

    /**
     * 删除命名空间v1
     *
     * @return void
     */
    public function testDeleteNamespaceRequestV1(): void
    {
        $request  = new DeleteNamespaceRequest();
        $instance = $request->v1('foo');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

    /**
     * 删除命名空间v2
     *
     * @return void
     */
    public function testDeleteNamespaceRequestV2(): void
    {
        $request  = new DeleteNamespaceRequest();
        $instance = $request->v2('foo');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

    /**
     * 查询具体命名空间v2
     *
     * @return void
     */
    public function testNamespaceRequest(): void
    {
        $request  = new CreateNamespaceRequest();
        $instance = $request->v2('foo', 'bar');
        $response = $this->nacosService->execute($instance);

        $request  = new NamespaceRequest();
        $instance = $request->v2('foo');
        $response = $this->nacosService->execute($instance);
        // var_dump($response->raw());
        // var_dump($response->response());
        $this->assertTrue(array_key_exists('code', $response->response()) && $response->response()['code'] == 0);
    }

}
