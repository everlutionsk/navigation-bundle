<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Factory;

use Everlution\Navigation\Factory\NavigationItemFactory;
use Everlution\Navigation\Factory\PropertyFactory;
use Everlution\Navigation\RootNavigationItem;
use Symfony\Component\Yaml\Parser;

/**
 * Class YamlNavigationItemFactory.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class YamlNavigationItemFactory extends NavigationItemFactory
{
    /** @var string */
    private $directory;
    /** @var Parser */
    private $parser;

    public function __construct(PropertyFactory $factory, Parser $parser, string $directory)
    {
        parent::__construct($factory);

        if (false === file_exists($directory)) {
            throw new DirectoryNotExistException($directory);
        }

        $this->directory = $directory;
        $this->parser = $parser;
    }

    /**
     * @param RootNavigationItem $navigation
     * @return array
     * @throws FileNotExistException
     */
    protected function getData(RootNavigationItem &$navigation): array
    {
        $filename = $this->getFilename($navigation->getIdentifier());
        if (false === file_exists($filename)) {
            throw new FileNotExistException($filename);
        }

        return $this->parser->parse(file_get_contents($filename));
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exists(string $name): bool
    {
        return file_exists($this->getFilename($name));
    }

    private function getFilename(string $name): string
    {
        return sprintf('%s/%s.yml', $this->directory, $name);
    }
}
