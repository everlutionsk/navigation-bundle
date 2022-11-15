<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Filter;

use Everlution\Navigation\Filter\RolesProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class RolesProvider.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RolesProvider implements RolesProviderInterface
{
    /** @var TokenStorage */
    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getRoles(): array
    {
        try {
            return array_merge(
                $this->tokenStorage->getToken()?->getUser()?->getRoles(),
                ['IS_AUTHENTICATED_FULLY']
            );
        } catch (\Exception $exception) {
            return ['PUBLIC_ACCESS'];
        }
    }
}
