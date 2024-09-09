<?php

namespace Nacosvel\Feign\Exception;

use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class HttpClientException extends RuntimeException implements GuzzleException
{

}
