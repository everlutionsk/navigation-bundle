<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Config;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Navigation.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class Navigation
{
    const OPTION_ITEMS = 'items';

    /** @var OptionsResolver */
    private $resolver;
    /** @var array */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->resolver = new OptionsResolver();

        $this->resolver->setRequired(self::OPTION_ITEMS);
        $this->resolver->setAllowedTypes(self::OPTION_ITEMS, 'array');
    }

    public function resolve(): array
    {
        return $this->resolver->resolve($this->config);
    }
}
