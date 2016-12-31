<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Url;

use Everlution\Navigation\Uri\Uri;

/**
 * Class ResolverContainer.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class ResolverContainer implements Resolver
{
    /** @var Resolver[] */
    private $resolvers = [];

    public function addResolver(Resolver $resolver)
    {
        if (in_array($resolver, $this->resolvers)) {
            throw new ResolverAlreadyRegistered($resolver);
        }

        $this->resolvers[] = $resolver;

        return $this;
    }

    /**
     * @param Uri $item
     * @return string
     * @throws \Exception
     */
    public function getUrl(Uri &$item): string
    {
        $url = null;
        foreach ($this->resolvers as $resolver) {
            if (is_string($url = $resolver->getUrl($item))) {
                return $url;
            }
        }

        throw new CannotResolveUrl();
    }
}
