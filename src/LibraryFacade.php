<?php

namespace OnkaarGujarr\Library;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OnkaarGujarr\Library\Skeleton\SkeletonClass
 */
class LibraryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'library';
    }
}
