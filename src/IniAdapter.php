<?php

declare(strict_types=1);

namespace Wherd\Config;

class IniAdapter implements IAdapter
{
    /** @var array<string,array<mixed>> */
    protected array $data = [];

    public function exists(string $filename): bool
    {
        return isset($this->data[$filename]) || (is_file($filename) && is_readable($filename));
    }

    /** @return array<mixed> */
    public function load(string $filename): array
    {
        if (isset($this->data[$filename])) {
            return $this->data[$filename];
        }

        if (!is_file($filename) || !is_readable($filename)) {
            throw new \InvalidArgumentException("File '$filename' is missing or is not readable.");
        }

        return $this->data[$filename] = ($data = parse_ini_file($filename, true)) ? $data : [];
    }

    /**
     * @param array<mixed> $data
     * @throws \RuntimeException if fails to write
     */
    public function save(string $filename, array $data): void
    {
        $this->data[$filename] = $data;

        if (false === file_put_contents($filename, $this->encode($data))) {
            throw new \RuntimeException("Cannot write file '$filename'.");
        }
    }

    /** @param array<mixed> $data */
    protected function encode(array $data): string
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

    protected function encodeValue(mixed $value): string
    {
        return is_numeric($value)
            ? (string) $value
            : (ctype_upper($value) ? $value : '"' . $value . '"');
    }
}
