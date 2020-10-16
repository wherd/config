<?php

namespace Wherd\Config\Adapters\Spec;

use \Wherd\Config\Adapters\IniAdapter;

describe('IniAdapter', function() {
    it('should load a INI file', function() {
        $adapter = new IniAdapter;
        $filename = dirname(__DIR__) . '/stubs/config.ini';

        $data = $adapter->load($filename);
        expect($data)->toBeA('array');
        expect($data)->toBe([
            'author' => ['name' => 'John Doe', 'organization' => 'Acme Widgets Inc.'],
            'database' => ['server' => '192.0.2.62', 'username' => 'root', 'password' => 'root', 'port' => 3306, 'persist' => false]
        ]);
    });

    it('should dump a INI file', function() {
        $data = [
            'author' => ['name' => 'John Doe', 'organization' => 'Acme Widgets Inc.'],
            'database' => ['server' => '192.0.2.62', 'username' => 'root', 'password' => 'root', 'port' => 3306, 'persist' => false]
        ];

        $string =  (new IniAdapter)->dump($data);
        $result = parse_ini_string($string, true, INI_SCANNER_TYPED);

        expect($result)->toBe($data);
    });
});
