<?php

namespace App\Application\Injector;

class Container
{
    /**
     * @param string[] $dependencies
     * @param bool $overrideMode
     */
    public function __construct(
        private readonly array $dependencies,
        private readonly bool $overrideMode = true,
    ) {
    }

    /**
     * @param string[] $outterDependencies
     * @return string[]
     */
    public function getDependencies(array $outterDependencies): array
    {
        if ($this->overrideMode) {
            return array_merge($this->dependencies, $outterDependencies);
        }

        return $this->dependencies;
    }
}
