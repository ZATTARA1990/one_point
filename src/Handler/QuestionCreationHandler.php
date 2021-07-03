<?php

declare(strict_types=1);

namespace App\Handler;

use App\DTO\QuestionRequestDTO;
use App\Entity\Question;
use App\Service\DatabaseManager\DatabaseManagerInterface;
use App\Service\DatabaseManager\DatabaseManagerLocator;
use App\Service\Creator\QuestionCreator;

class QuestionCreationHandler
{
    /**
     * @var QuestionCreator
     */
    private QuestionCreator $questionCreator;

    /**
     * @var DatabaseManagerInterface
     */
    private DatabaseManagerInterface $databaseManager;

    /**
     * @param QuestionCreator $questionCreator
     * @param DatabaseManagerLocator $databaseManagerLocator
     */
    public function __construct(QuestionCreator $questionCreator, DatabaseManagerLocator $databaseManagerLocator)
    {
        $this->questionCreator = $questionCreator;
        $this->databaseManager = $databaseManagerLocator->get();
    }

    /**
     * @param QuestionRequestDTO $questionRequest
     *
     * @return Question
     */
    public function handle(QuestionRequestDTO $questionRequest): Question
    {
        $question = $this->questionCreator->create($questionRequest);

        $this->databaseManager->add($question, Question::class);

        return $question;
    }
}
