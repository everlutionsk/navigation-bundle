<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Voter;

use Everlution\Navigation\Matcher\VoterContainer;
use Everlution\Navigation\Voter\Matchable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestAware.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
abstract class RequestAwareVoter extends VoterContainer implements MatchVoter
{
    /** @var RequestStack */
    private $requestStack;

    public function __construct(RequestStack $requestStack, array $voters = [])
    {
        $this->requestStack = $requestStack;

        foreach ($voters as $voter) {
            $this->addVoter($voter);
        }
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * @param string $haystack
     * @param Matchable $item
     * @return bool
     */
    protected function matches(string $haystack, Matchable $item): bool
    {
        foreach ($this->getVoters() as $voter) {
            if ($voter->match($haystack, $item)) {
                return true;
            }
        }

        return false;
    }
}
