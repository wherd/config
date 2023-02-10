<?php

declare(strict_types=1);

namespace Wherd\Config;

interface IAdapter
{
    /** @return array<mixed> */
    public function load(string $filename): array;

    /** @param array<mixed> $data */
    public function save(string $filename, array $data): void;
}
