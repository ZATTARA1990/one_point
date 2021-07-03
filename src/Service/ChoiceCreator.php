<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\ChoiceRequestDTO;
use App\Entity\Choice;

class ChoiceCreator
{
    public function create(ChoiceRequestDTO $choiceRequestDTO): Choice
    {
        return new Choice($choiceRequestDTO->text);
    }
}
