<?php

declare(strict_types=1);

namespace App\Entity;

class Question
{
    /**
     * @var string
     */
    private string $text;

    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $createdAt;

    /**
     * @var Choice[]
     */
    private array $choices;

    /**
     * @param string $text
     * @param \DateTimeInterface $createdAt
     * @param array $choices
     */
    public function __construct(string $text, \DateTimeInterface $createdAt, array $choices)
    {
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->choices = $choices;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return array|Choice[]
     */
    public function getChoices(): array
    {
        return $this->choices;
    }
}
