<?php

/*
 * Config - Yet another config loader.
 * Copyright (c) 2020 Wherd (https://www.wherd.dev).
 */

namespace Wherd\Config;

use InvalidArgumentException;
use RuntimeException;

class Loader
{
    /**
     * Registered config handlers.
     * @var array<string,class-string>
     */
    protected $adapters = [
        'php' => 'Wherd\\Config\\Adapters\\PhpAdapter',
        'json' => 'Wherd\\Config\\Adapters\\JsonAdapter',
        'ini' => 'Wherd\\Config\\Adapters\\IniAdapter',
    ];

    protected string $basePath;

    /**
     * Create a new configration loader.
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Configuration files exists.
     * @param string $filename
     * @return bool
     */
    public function exists($filename)
    {
        $path = $this->getPath($filename);
        return is_file($path) && is_readable($path);
    }
    
    /**
     * Load and return configuration data.
     * @param string $filename
     * @return array<mixed>
     */
    public function load($filename)
    {
        $path = $this->getPath($filename);

        if (!is_file($path) || !is_readable($path)) {
            throw new InvalidArgumentException("File '$filename' is missing or is not readable.");
        }

        return $this->getAdapter($filename)->load($path);
    }

    /**
     * Save given configuration data to file.
     * @param array<mixed> $data
     * @param string $filename
     * @return self
     */
    public function save($data, $filename)
    {
        $path = $this->getPath($filename);

        if (false === file_put_contents($path, $this->getAdapter($filename)->dump($data))) {
            throw new RuntimeException("Cannot write file '$filename'.");
        }

        return $this;
    }

    /**
     * Register a new adapter.
     * @param string $extension
     * @param class-string $adapter
     * @return self
     */
    public function addAdapter($extension, $adapter)
    {
        $this->adapters[strtolower($extension)] = $adapter;
        return $this;
    }
    
    /**
     * Get config file adapter.
     * @param string $filename
     * @return IAdapter
     */
    public function getAdapter($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!isset($this->adapters[$extension])) {
            throw new InvalidArgumentException("Unknown file extension '$filename'.");
        }

        return new $this->adapters[$extension];
    }

    /**
     * Get configuration file full path.
     * @param string $filename
     * @return string
     */
    protected function getPath($filename)
    {
        return $this->basePath . '/' . ltrim($filename, '/');
    }
}
