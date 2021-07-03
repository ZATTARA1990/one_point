<?php

declare(strict_types=1);

namespace App\DTO;

use App\Request\RequestDataInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ChoiceRequestDTO implements RequestDataInterface
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    public string $text = '';
}
