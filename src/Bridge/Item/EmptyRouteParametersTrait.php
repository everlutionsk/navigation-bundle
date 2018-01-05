<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item;

/**
 * Trait EmptyRouteParametersTrait.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
trait EmptyRouteParametersTrait
{
    public function getParameters(): array
    {
        return [];
    }
}
