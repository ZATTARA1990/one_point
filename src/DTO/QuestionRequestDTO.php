<?php

declare(strict_types=1);

namespace App\DTO;

use App\Request\RequestDataInterface;
use Symfony\Component\Validator\Constraints as Assert;

class QuestionRequestDTO implements RequestDataInterface
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    public string $text = '';

    /**
     * @Assert\NotBlank()
     *
     * @var \DateTimeInterface
     */
    public $createdAt;

    /**
     * @Assert\Type("array")
     * @Assert\Count(min=3, max=3)
     * @Assert\NotBlank()
     * @Assert\Valid()
     *
     * @var ChoiceRequestDTO[]
     */
    public array $choices = [];
}
