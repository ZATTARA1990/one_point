<?php

declare(strict_types=1);

namespace App\DTO;

use App\Request\RequestDataInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ListQuestionsQueryDTO implements RequestDataInterface
{
    /**
     * @Assert\Language()
     * @Assert\NotBlank()
     *
     * @var string
     */
    public string $lang = '';
}
