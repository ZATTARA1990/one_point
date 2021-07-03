<?php

declare(strict_types=1);

namespace App\Service\DatabaseManager;

class DatabaseManagerLocator
{
    /**
     * @var array
     */
    private array $databaseManagers;

    /**
     * @var string
     */
    private string $databaseType;

    /**
     * @param \Traversable $databaseManagers
     * @param string $databaseType
     */
    public function __construct(\Traversable $databaseManagers, string $databaseType)
    {
        $this->databaseManagers = iterator_to_array($databaseManagers);
        $this->databaseType = $databaseType;
    }

    /**
     * @return DatabaseManagerInterface
     */
    public function get(): DatabaseManagerInterface
    {
        return $this->databaseManagers[$this->databaseType];
    }
}
