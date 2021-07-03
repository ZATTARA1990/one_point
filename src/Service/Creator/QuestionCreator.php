<?php

declare(strict_types=1);

namespace App\Service\Creator;

use App\DTO\QuestionRequestDTO;
use App\Entity\Question;

class QuestionCreator
{
    /**
     * @var ChoiceCreator
     */
    private ChoiceCreator $choiceCreator;

    /**
     * @param ChoiceCreator $choiceCreator
     */
    public function __construct(ChoiceCreator $choiceCreator)
    {
        $this->choiceCreator = $choiceCreator;
    }

    /**
     * @param QuestionRequestDTO $questionRequest
     * @return Question
     */
    public function create(QuestionRequestDTO $questionRequest): Question
    {
        $choices = array_map([$this->choiceCreator, 'create'], $questionRequest->choices);

        return new Question($questionRequest->text, $questionRequest->createdAt, $choices);
    }
}
