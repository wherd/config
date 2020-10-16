<?php

/*
 * Config - Yet another config loader.
 * Copyright (c) 2020 Wherd (https://www.wherd.dev).
 */

namespace Wherd\Config\Adapters;

use Wherd\Config\IAdapter;

class IniAdapter implements IAdapter
{
    /** @inheritdoc */
    public function load($filename)
    {
        return parse_ini_file($filename, true, INI_SCANNER_TYPED) ?: [];
    }

    /** @inheritdoc */
    public function dump($data)
    {
        ob_start();

        foreach ($data as $sectionName => $sectionValue) {
            if (is_array($sectionValue)) {
                echo "[$sectionName]\n";
                
                foreach ($sectionValue as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $arrayKey => $arrayValue) {
                            echo is_numeric($arrayKey)
                                ? "{$key}[] = {$this->encodeValue($arrayValue)}\n"
                                : "{$key}[{$arrayKey}] = {$this->encodeValue($arrayValue)}\n";
                        }
                    } else {
                        echo "$key = {$this->encodeValue($value)}\n";
                    }
                }
            } else {
                echo "$sectionName = {$this->encodeValue($sectionValue)}\n";
            }

            echo "\n";
        }

        return (string) ob_get_clean();
    }

    /**
     * Encode value.
     * @param mixed $value
     * @return string
     */
    protected function encodeValue($value)
    {
        $type = gettype($value);

        switch ($type) {
            case 'boolean':
                return $value ? 'true' : 'false';
            case 'integer':
                return (string) $value;
        }

        return is_numeric($value)
            ? (string) $value
            : (ctype_upper($value) ? $value : '"' . $value . '"');
    }
}
