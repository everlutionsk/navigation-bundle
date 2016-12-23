<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Voter;

use Everlution\Navigation\Voter\Matchable;

/**
 * Class RouteMatcher.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RouteVoter extends RequestAwareVoter
{
    /**
     * @param Matchable $item
     * @return bool
     */
    public function match(Matchable $item): bool
    {
        return $this->matches($this->getRequest()->get('_route'), $item);
    }
}
