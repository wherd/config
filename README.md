# Config

Yet another config wrapper.

## Installation

Install using composer:

```bash
composer require wherd/config
```

# Usage

```php
use Wherd\Config\PhpAdapter;

$config = new PhpAdapter();
$data = $config->load('filename.php');
```