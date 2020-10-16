<?php

namespace Wherd\Config\Adapters\Spec;

use \Wherd\Config\Adapters\JsonAdapter;

describe('JsonAdapter', function() {
    it('should load a json file', function() {
        $adapter = new JsonAdapter;
        $filename = dirname(__DIR__) . '/stubs/config.json';

        $data = $adapter->load($filename);
        expect($data)->toBeA('array');
        expect($data)->toBe([
            'author' => ['name' => 'John Doe', 'organization' => 'Acme Widgets Inc.'],
            'database' => ['server' => '192.0.2.62', 'username' => 'root', 'password' => 'root', 'port' => 3306, 'persist' => false]
        ]);
    });

    it('should dump a json file', function() {
        $data = [
            'author' => ['name' => 'John Doe', 'organization' => 'Acme Widgets Inc.'],
            'database' => ['server' => '192.0.2.62', 'username' => 'root', 'password' => 'root', 'port' => 3306, 'persist' => false]
        ];

        $string =  (new JsonAdapter)->dump($data);
        $result = json_decode($string, true);

        expect($result)->toBe($data);
    });
});
