<?php

declare(strict_types=1);

namespace App\Service;

class CSVDatabaseManager extends FileDatabaseManager
{
    public static function getType(): string
    {
        return 'csv';
    }
}
