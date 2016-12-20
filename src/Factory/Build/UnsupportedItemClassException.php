<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Factory\Build;

/**
 * Class UnsupportedItemClassException.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class UnsupportedItemClassException extends \InvalidArgumentException
{
    public function __construct(string $class, array $supportedClasses)
    {
        parent::__construct(
            sprintf(
                "Cannot create object of type '%s'. Supported classes: %s.
                Did you forget to specify supported classes within config() method?",
                $class,
                implode(', ', $supportedClasses)
            )
        );
    }
}
