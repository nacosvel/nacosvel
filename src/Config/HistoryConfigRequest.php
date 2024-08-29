<?php

namespace Nacosvel\NacosClient\Config;

use Nacosvel\NacosClient\Contracts\V1\Config\HistoryConfigInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Config\HistoryConfigInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class HistoryConfigRequest extends NacosRequestResponse implements V1, V2
{

}
