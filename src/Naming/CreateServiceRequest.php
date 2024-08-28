<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\Nacos\NacosRequest;
use Nacosvel\NacosClient\Contracts\V1\Naming\CreateServiceInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Naming\CreateServiceInterface as V2;

class CreateServiceRequest extends NacosRequest implements V1, V2
{

}
