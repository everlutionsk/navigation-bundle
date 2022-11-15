<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Item;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestAttributesContainer.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class RequestAttributesContainer implements RequestAttributesContainerInterface
{
    /** @var RequestStack */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function get(string $name, string $default = ''): string
    {
        $request = $this->requestStack->getMainRequest();

        if (!$request) {
            return '';
        }

        return $request->get($name, $default);
    }
}
