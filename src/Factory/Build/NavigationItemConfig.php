<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Factory\Build;

use Everlution\Navigation\Item;
use Everlution\NavigationBundle\Factory\ItemFactory;
use Everlution\NavigationBundle\Navigation\NavigationItemClassDoesNotExistException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NavigationItemConfig.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
abstract class NavigationItemConfig implements Config
{
    const OPTION_CLASS = 'class';
    const OPTION_LABEL = 'label';
    const OPTION_IDENTIFIER = 'identifier';
    const OPTION_CHILDREN = 'children';

    /** @var OptionsResolver */
    protected $resolver;
    /** @var array */
    protected $supportedClasses = [];

    public function __construct()
    {
        $this->resolver = new OptionsResolver();

        $this->resolver->setRequired(
            [
                self::OPTION_CLASS,
                self::OPTION_LABEL,
                self::OPTION_IDENTIFIER,
                self::OPTION_CHILDREN,
            ]
        );
        $this->resolver->setAllowedTypes(self::OPTION_CLASS, 'string');
        $this->resolver->setAllowedTypes(self::OPTION_LABEL, 'string');
        $this->resolver->setAllowedTypes(self::OPTION_IDENTIFIER, 'string');
        $this->resolver->setAllowedTypes(self::OPTION_CHILDREN, 'array');

        $this->resolver->setDefault(self::OPTION_CHILDREN, []);

        $this->config();
    }

    /**
     * @param Item $item
     * @param ItemFactory $factory
     * @return array
     */
    public function toArray(Item $item, ItemFactory $factory): array
    {
        $this->checkIfSupport(get_class($item));

        $result = $this->getArray($item);

        foreach ($item->getChildren() as $child) {
            $result[static::OPTION_CHILDREN][] = $factory->flatten($child);
        }

        return $result;
    }

    /**
     * @param array $config
     * @param ItemFactory $factory
     * @return Item
     * @throws NavigationItemClassDoesNotExistException
     */
    public function toObject(array $config, ItemFactory $factory): Item
    {
        $className = $this->popClassName($config);
        $this->checkIfSupport($className);

        $config = $this->resolve($config);

        if (false === class_exists($className)) {
            throw new NavigationItemClassDoesNotExistException($className);
        }

        $object = $this->getObject($className, $config);

        foreach ($config[self::OPTION_CHILDREN] as $item) {
            $child = $factory->create($item);
            $object->addChild($child);
        }

        return $object;
    }

    /**
     * @param array $config
     * @return array
     */
    protected function resolve(array $config): array
    {
        return $this->resolver->resolve($config);
    }

    /**
     * @param string $class
     */
    protected function checkIfSupport(string $class)
    {
        if (false === in_array($class, $this->supportedClasses)) {
            throw new UnsupportedItemClassException($class, $this->supportedClasses);
        }
    }

    /**
     * Specifies how the object should be created
     *
     * @param string $className
     * @param array $arguments
     * @return Item
     */
    abstract protected function getObject(string $className, array $arguments);

    /**
     * Specifies how should object be transformed to an array
     *
     * @param Item $item
     * @return array
     */
    abstract protected function getArray($item): array;

    /**
     * Specifies additional options
     * This method is called after initial OptionsResolver setup
     * Use OptionsResolver within this method
     *
     * @return void
     */
    abstract protected function config();

    /**
     * @param array $config
     * @return string
     */
    private function popClassName(array $config): string
    {
        $class = $config[self::OPTION_CLASS];
        unset($config[self::OPTION_CLASS]);

        return $class;
    }
}
