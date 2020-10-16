<?php

/*
 * Config - Yet another config loader.
 * Copyright (c) 2020 Wherd (https://www.wherd.dev).
 */

namespace Wherd\Config;

interface IAdapter
{
    /**
     * Load configuration file.
     * @param string $filename
     * @return array<mixed>
     */
    public function load($filename);

    /**
     * Convert configuration data to string.
     * @param array<mixed> $data
     * @return string
     */
    public function dump($data);
}
