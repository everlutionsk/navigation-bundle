<?php

declare(strict_types=1);

namespace Everlution\NavigationBundle\Bridge;

/**
 * Class NavigationAliasContainer.
 *
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationAliasContainer
{
    private $container = [];

    public function addAlias(string $alias, string $class): void
    {
        $this->container[$alias] = $class;
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws AliasDoesNotExistException
     */
    public function get(string $name): string
    {
        if (class_exists($name)) {
            // we received class name instead of the alias
            return $name;
        }

        if (array_key_exists($name, $this->container)) {
            // alias exists returning the class name
            return $this->container[$name];
        }

        throw new AliasDoesNotExistException($name);
    }
}
