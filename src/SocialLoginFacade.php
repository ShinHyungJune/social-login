<?php

namespace ShinHyungJune\SocialLogin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ShinHyungJune\SocialLogin\Skeleton\SkeletonClass
 */
class SocialLoginFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'social-login';
    }
}
