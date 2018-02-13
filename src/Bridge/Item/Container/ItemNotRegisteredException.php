<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item\Container;

/**
 * Class ItemNotRegisteredException.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class ItemNotRegisteredException extends \Exception
{
    public function __construct(string $name)
    {
        parent::__construct("Item with name '$name' has not been registered.");
    }
}
