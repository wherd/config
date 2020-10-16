<?php

/*
 * Config - Yet another config loader.
 * Copyright (c) 2020 Wherd (https://www.wherd.dev).
 */

namespace Wherd\Config\Adapters;

use Wherd\Config\IAdapter;

class JsonAdapter implements IAdapter
{
    /** @inheritdoc */
    public function load($filename)
    {
        return json_decode((string) file_get_contents($filename), true, 512, JSON_THROW_ON_ERROR);
    }

    /** @inheritdoc */
    public function dump($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
    }
}
