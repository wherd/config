<?php

declare(strict_types=1);

namespace Wherd\Config;

class PhpAdapter implements IAdapter
{
    /** @var array<string,array<mixed>> */
    protected array $data = [];

    public function exists(string $filename): bool
    {
        return isset($this->data[$filename]) || (is_file($filename) && is_readable($filename));
    }

    /**
     * @return array<mixed>
     * @throws \InvalidArgumentException if file is missing
     */
    public function load(string $filename): array
    {
        if (isset($this->data[$filename])) {
            return $this->data[$filename];
        }

        if (!is_file($filename) || !is_readable($filename)) {
            throw new \InvalidArgumentException("File '$filename' is missing or is not readable.");
        }

        return $this->data[$filename] = require $filename;
    }

    /**
     * @param array<mixed> $data
     * @throws \RuntimeException if fails to write
     */
    public function save(string $filename, array $data): void
    {
        $this->data[$filename] = $data;

        if (false === file_put_contents($filename, '<?php return ' . var_export($data, true) . ';')) {
            throw new \RuntimeException("Cannot write file '$filename'.");
        }
    }
}
