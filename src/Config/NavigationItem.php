<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Config;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NavigationItem.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationItem
{
    const OPTION_CLASS = 'class';
    const OPTION_LABEL = 'label';
    const OPTION_IDENTIFIER = 'identifier';

    /** @var OptionsResolver */
    private $resolver;
    /** @var array */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->resolver = new OptionsResolver();

        $this->resolver->setRequired([self::OPTION_CLASS, self::OPTION_LABEL, self::OPTION_IDENTIFIER]);
        $this->resolver->setAllowedTypes(self::OPTION_CLASS, 'string');
        $this->resolver->setAllowedTypes(self::OPTION_LABEL, 'string');
        $this->resolver->setAllowedTypes(self::OPTION_IDENTIFIER, 'string');
    }

    public function resolve(): array
    {
        return $this->resolver->resolve($this->config);
    }

}
