<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Matcher;

use Everlution\Navigation\NavigationItem;
use Everlution\Navigation\Voter;

/**
 * Class RouteMatcher.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RouteVoter extends RequestAware implements Voter
{
    public function match(NavigationItem $item): bool
    {
        return $this->getRequest()->get('_route') === $item->getIdentifier();
    }
}
