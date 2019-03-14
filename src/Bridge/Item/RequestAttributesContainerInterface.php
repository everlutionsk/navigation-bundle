<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item;

/**
 * Interface RequestAttributesContainerInterface.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
interface RequestAttributesContainerInterface
{
    public function get(string $name, string $default = ''): string;
}
