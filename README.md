# Wherd Config

Yet another config loader

## Installation

Install using composer:

```
composer require wherd/config
```

## Usage

To load or save a configuration file create a new instance of `Wherd\Config\Loader` class:

```php
$loader = new Wherd\Config\Loader($basePath); // by default can save and load .php, .json and .ini files
$config = $config->load('site.json');

$config['database'] = ['dsn' => 'sqlite::memory:'];
$loader->save($config, 'site.json');
```

You can also add your own configuration adapter:

```php
$loader = new Wherd\Config\Loader($basePath); // by default can save and load .php, .json and .ini files
$loader->addAdapter('yml', 'My\\Custom\\YmlAdapter');

$config = $loader->load('site.yml');
```
