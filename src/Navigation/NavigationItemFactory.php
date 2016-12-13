<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Navigation;

use Everlution\Navigation\Item;
use Everlution\NavigationBundle\Config\RootNavigationItem;
use Everlution\NavigationBundle\Config\NavigationItem;
use Symfony\Component\Yaml\Parser;

/**
 * Class NavigationItemFactory.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class NavigationItemFactory
{
    /** @var string */
    private $directory;
    /** @var Parser */
    private $parser;

    public function __construct(Parser $parser, string $directory)
    {
        if (false === file_exists($directory)) {
            throw new DirectoryNotExistException($directory);
        }

        $this->directory = $directory;
        $this->parser = $parser;
    }

    public function build(\Everlution\Navigation\NavigationItem &$navigation)
    {
        $filename = $this->getFilename($navigation->getUri());
        if (false === file_exists($filename)) {
            throw new FileNotExistException($filename);
        }

        $content = $this->parser->parse(file_get_contents($filename));
        $items = (new RootNavigationItem($content))->resolve();

        foreach ($items as $item) {
            $item = $this->create($item);
            $navigation->addChild($item);
        }
    }

    private function create(array $item)
    {
        $item = (new NavigationItem($item))->resolve();

        $class = $item[NavigationItem::OPTION_CLASS];
        if (false === class_exists($class)) {
            throw new NavigationItemClassDoesNotExistException($class);
        }

        /** @var Item $instance */
        $instance = new $class($item[NavigationItem::OPTION_IDENTIFIER], $item[NavigationItem::OPTION_LABEL]);

        if (!$instance instanceof Item) {
            throw new InvalidNavigationItemInstanceException($class);
        }

        foreach ($item[NavigationItem::OPTION_CHILDREN] as $child) {
            $child = $this->create($child);
            $instance->addChild($child);
        }

        return $instance;
    }

    public function exists(string $name): bool
    {
        return file_exists($this->getFilename($name));
    }

    private function getFilename(string $name): string
    {
        return sprintf('%s/%s.yml', $this->directory, $name);
    }
}
