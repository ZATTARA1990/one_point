<?php

declare(strict_types=1);

namespace App\Service\DatabaseManager;

interface DatabaseManagerInterface
{
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return string
     */
    public static function getType(): string;

    /**
     * @param object $entity
     * @param string $entityClass
     */
    public function add(object $entity, string $entityClass): void;

    /**
     * @param string $entityClass
     *
     * @return array
     */
    public function list(string $entityClass): array;
}
