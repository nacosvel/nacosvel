<?php

namespace Test;

use Nacosvel\NacosClient\NacosService;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected NacosService $nacosService;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->nacosService = new NacosService('http://127.0.0.1:8848');
    }

}
