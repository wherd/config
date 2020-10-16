<?php

/*
 * Config - Yet another config loader.
 * Copyright (c) 2020 Wherd (https://www.wherd.dev).
 */

namespace Wherd\Config\Adapters;

use Wherd\Config\IAdapter;

class PhpAdapter implements IAdapter
{
    /** @inheritdoc */
    public function load($filename)
    {
        return require $filename;
    }

    /** @inheritdoc */
    public function dump($data)
    {
        return '<?php return ' . var_export($data, true) . ';';
    }
}
