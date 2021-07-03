<?php

declare(strict_types=1);

namespace App\Service\Creator;

use App\DTO\ChoiceRequestDTO;
use App\Entity\Choice;

class ChoiceCreator
{
    /**
     * @param ChoiceRequestDTO $choiceRequestDTO
     *
     * @return Choice
     */
    public function create(ChoiceRequestDTO $choiceRequestDTO): Choice
    {
        return new Choice($choiceRequestDTO->text);
    }
}
