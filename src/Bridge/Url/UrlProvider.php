<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge\Url;

use Everlution\Navigation\Item\ItemInterface;
use Everlution\Navigation\Url\UrlProviderInterface;
use Everlution\NavigationBundle\Bridge\Item\RoutableInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UrlProvider.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class UrlProvider implements UrlProviderInterface
{
    /** @var RouterInterface */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param ItemInterface|RoutableInterface $item
     *
     * @return string
     *
     * @throws ItemIsNotSupportedException
     */
    public function getUrl(ItemInterface $item): string
    {
        if (false === $this->supports($item)) {
            throw new ItemIsNotSupportedException($item, RouterInterface::class);
        }

        return $this->router->generate($item->getRoute(), $item->getParameters());
    }

    public function supports(ItemInterface $item): bool
    {
        return $item instanceof RoutableInterface;
    }
}
