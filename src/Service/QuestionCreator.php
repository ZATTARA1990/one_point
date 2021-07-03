<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\QuestionRequestDTO;
use App\Entity\Question;

class QuestionCreator
{
    private ChoiceCreator $choiceCreator;

    public function __construct(ChoiceCreator $choiceCreator)
    {
        $this->choiceCreator = $choiceCreator;
    }

    public function create(QuestionRequestDTO $questionRequest): Question
    {
        $choices = array_map([$this->choiceCreator, 'create'], $questionRequest->choices);

        return new Question($questionRequest->text, $questionRequest->createdAt, $choices);
    }
}
