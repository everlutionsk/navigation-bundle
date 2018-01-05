<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Service\Url;

/**
 * Interface RoutableInterface.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
interface RoutableInterface
{
    public function getRoute(): string;

    public function getParameters(): array;
}
