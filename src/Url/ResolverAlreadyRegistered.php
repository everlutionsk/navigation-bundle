<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Url;

/**
 * Class ResolverAlreadyRegistered.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class ResolverAlreadyRegistered extends \Exception
{
    public function __construct(Resolver $resolver)
    {
        parent::__construct(
            sprintf("Resolver '%s' already registered.", get_class($resolver))
        );
    }
}
