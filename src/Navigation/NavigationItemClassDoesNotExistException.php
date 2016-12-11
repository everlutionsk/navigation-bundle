<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Navigation;

/**
 * Class NavigationItemClassDoesNotExistException.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationItemClassDoesNotExistException extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct(
            sprintf("Cannot create navigation item. Class '%s' does not exist.", $class)
        );
    }
}
