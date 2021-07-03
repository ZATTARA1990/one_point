<?php

declare(strict_types=1);

namespace App\Service;

interface DatabaseManagerInterface
{
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    public static function getType(): string;

    public function add(object $entity, string $entityClass): void;

    public function list(string $entityClass): array;
}
