<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge;

use Everlution\Navigation\Builder\MatcherInterface;
use Everlution\Navigation\Item\ItemInterface;
use Everlution\Navigation\Item\MatchableInterface;
use Everlution\Navigation\Match\UrlMatchVoterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class Matcher.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class Matcher implements MatcherInterface
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

    public function isCurrent(ItemInterface $item): bool
    {
        if (!$item instanceof MatchableInterface) {
            return false;
        }

        // we search matches within URL and route
        foreach ([$this->request->getPathInfo(), $this->request->get('_route')] as $url) {
            if ($this->voter->matches($url, $item)) {
                return true;
            }
        }

        return false;
    }
}
