<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Url;

use Everlution\Navigation\Uri\Uri;

/**
 * Interface Resolver.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
interface Resolver
{
    public function getUrl(Uri &$uri);
}
