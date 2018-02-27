<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge;

use Everlution\Navigation\ContainerInterface;
use Everlution\Navigation\Item\MatchableInterface;
use Everlution\Navigation\Match\UrlMatchVoterInterface;
use Everlution\Navigation\ContainerBuilder\ContainerMatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class Matcher.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationContainerMatcher implements ContainerMatcherInterface
{
    /** @var UrlMatchVoterInterface */
    private $voter;
    /** @var Request */
    private $request;

    public function __construct(RequestStack $requestStack, UrlMatchVoterInterface $voter)
    {
        $this->request = $requestStack->getMasterRequest();
        $this->voter = $voter;
    }

    public function isCurrent(ContainerInterface $item): bool
    {
        if (!$item instanceof MatchableInterface) {
            return false;
        }

        // we search matches within URL and route
        foreach ([$this->request->getPathInfo(), $this->request->get('_route', '')] as $url) {
            if ($this->voter->matches($url, $item)) {
                return true;
            }
        }

        return false;
    }
}
