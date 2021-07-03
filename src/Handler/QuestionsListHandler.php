<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Question;
use App\Service\DatabaseManagerInterface;
use App\Service\DatabaseManagerLocator;

class QuestionsListHandler
{
    /**
     * @var DatabaseManagerInterface
     */
    private DatabaseManagerInterface $databaseManager;

    /**
     * @param DatabaseManagerLocator $databaseManagerLocator
     */
    public function __construct(DatabaseManagerLocator $databaseManagerLocator)
    {
        $this->databaseManager = $databaseManagerLocator->get();
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->databaseManager->list(Question::class);
    }
}
