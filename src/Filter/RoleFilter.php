<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Filter;

use Everlution\Navigation\Filter\FilterInterface;
use Everlution\Navigation\Item;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @author Klinec <matus.pavlik@everlution.com>
 */
class RoleFilter implements FilterInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function shouldFilterOut(Item $item): bool
    {
        return false === $this->authorizationChecker->isGranted($item->getRoles());
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isApplicable(Item $item): bool
    {
        return false === empty($item->getRoles());
    }
}
