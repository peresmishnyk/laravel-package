<?php

namespace {vendor|studly}\{package|studly};

use Illuminate\Support\Facades\Facade;

/**
 * @see \Peresmishnyk\Boilerplate\Skeleton\SkeletonClass
 */
class {package|studly}Facade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'boilerplate';
    }
}
