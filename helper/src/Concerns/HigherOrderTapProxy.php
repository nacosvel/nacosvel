<?php

namespace Nacosvel\Helper\Concerns;

/**
 * @template TValue
 */
class HigherOrderTapProxy
{
    /**
     * The target being tapped.
     *
     * @var TValue
     */
    public mixed $target;

    /**
     * Create a new tap proxy instance.
     *
     * @param TValue $target
     *
     * @return void
     */
    public function __construct(mixed $target)
    {
        $this->target = $target;
    }

    /**
     * Dynamically pass method calls to the target.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return TValue
     */
    public function __call(string $method, array $parameters)
    {
        $this->target->{$method}(...$parameters);

        return $this->target;
    }
}
