<?php

declare(strict_types = 1);

namespace Everlution\NavigationBundle\DataProvider;

use Everlution\Navigation\Provider\DataProvider;
use Everlution\NavigationBundle\DataProvider\DirectoryNotExistException;
use Everlution\NavigationBundle\DataProvider\FileNotExistException;
use Symfony\Component\Yaml\Parser;

/**
 * Class YamlDataProvider.
 * @author Ivan Barlog <ivan.barlog@everlution.sk>
 */
class YamlDataProvider implements DataProvider
{
    /** @var string */
    private $directory;
    /** @var Parser */
    private $parser;

    public function __construct(Parser $parser, string $directory)
    {
        if (false === $this->exists($directory)) {
            throw new DirectoryNotExistException($directory);
        }

        $this->directory = $directory;
        $this->parser = $parser;
    }

    /**
     * @param string $identifier
     * @return array
     * @throws FileNotExistException
     */
    public function getData(string $identifier): array
    {
        $filename = $this->getFilename($identifier);
        if (false === $this->exists($filename)) {
            throw new FileNotExistException($filename);
        }

        return $this->parser->parse(file_get_contents($filename));
    }

    /**
     * @param string $identifier
     * @return bool
     */
    public function canHandle(string $identifier): bool
    {
        return $this->exists($this->getFilename($identifier));
    }

    /**
     * @param string $filename
     * @return bool
     */
    private function exists(string $filename): bool
    {
        return file_exists($filename);
    }

    private function getFilename(string $name): string
    {
        return sprintf('%s/%s.yml', $this->directory, $name);
    }
}
