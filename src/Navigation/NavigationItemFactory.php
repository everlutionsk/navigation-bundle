<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\Navigation;

use Everlution\NavigationBundle\Config\Navigation;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

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

    public function build(string $name)
    {
        $filename = $this->getFilename($name);
        if (false === file_exists($filename)) {
            throw new FileNotExistException($filename);
        }

        $content = $this->parser->parse(file_get_contents($filename));
        $items = (new Navigation($content))
    }

    private function getFilename(string $name): string
    {
        return sprintf('%s/%s.yaml', $this->directory, $name);
    }
}
