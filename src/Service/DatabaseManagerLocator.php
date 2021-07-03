<?php

declare(strict_types=1);

namespace App\Service;

class DatabaseManagerLocator
{
    private array $databaseManagers;

    private string $databaseType;

    public function __construct(\Traversable $databaseManagers, string $databaseType)
    {
        $this->databaseManagers = iterator_to_array($databaseManagers);
        $this->databaseType = $databaseType;
    }

    public function get(): DatabaseManagerInterface
    {
        return $this->databaseManagers[$this->databaseType];
    }
}
