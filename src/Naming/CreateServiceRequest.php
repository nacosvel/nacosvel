<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\V1\Naming\CreateServiceInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Naming\CreateServiceInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class CreateServiceRequest extends NacosRequestResponse implements V1, V2
{

}
