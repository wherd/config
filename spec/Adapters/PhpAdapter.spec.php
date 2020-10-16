<?php

namespace Wherd\Config\Adapters\Spec;

use \Wherd\Config\Adapters\PhpAdapter;

describe('PhpAdapter', function() {
    it('should load a php file', function() {
        $adapter = new PhpAdapter;
        $filename = dirname(__DIR__) . '/stubs/config.php';

        $data = $adapter->load($filename);
        expect($data)->toBeA('array');
        expect($data)->toBe([
            'author' => ['name' => 'John Doe', 'organization' => 'Acme Widgets Inc.'],
            'database' => ['server' => '192.0.2.62', 'username' => 'root', 'password' => 'root', 'port' => 3306, 'persist' => false]
        ]);
    });

    it('should dump a php file', function() {
        $data = [
            'author' => ['name' => 'John Doe', 'organization' => 'Acme Widgets Inc.'],
            'database' => ['server' => '192.0.2.62', 'username' => 'root', 'password' => 'root', 'port' => 3306, 'persist' => false]
        ];

        $string =  (new PhpAdapter)->dump($data);
        $result = eval('?>' . $string);

        expect($result)->toBe($data);
    });
});
