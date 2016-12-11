<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Navigation;

use Everlution\Navigation\Item;

/**
 * Class InvalidNavigationItemInstanceException.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class InvalidNavigationItemInstanceException extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct(
            sprintf(
                "Class '%s' must implement %s interface",
                $class,
                Item::class
            )
        );
    }
}
