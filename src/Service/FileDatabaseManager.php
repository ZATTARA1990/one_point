<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class FileDatabaseManager implements DatabaseManagerInterface
{
    private string $filePath;

    private SerializerInterface $serializer;

    abstract public static function getType(): string;

    public function __construct(string $databaseDSN, SerializerInterface $serializer)
    {
        $this->filePath = parse_url($databaseDSN)['path'];
        $this->serializer = $serializer;
    }

    public function add(object $entity, string $entityClass): void
    {
        $entities = $this->list($entityClass);

        file_put_contents(
            $this->filePath,
            $this->serializer->serialize([...$entities, $entity], static::getType(), [
                DateTimeNormalizer::FORMAT_KEY => self::DATE_TIME_FORMAT,
            ])
        );
    }

    public function list(string $entityClass): array
    {
        $dbFileContent = file_get_contents($this->filePath);

        return $this->serializer->deserialize($dbFileContent, $entityClass.'[]', static::getType());
    }
}
