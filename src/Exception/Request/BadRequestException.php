<?php

declare(strict_types=1);

namespace App\Exception\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class BadRequestException extends \Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    private ConstraintViolationListInterface $violationList;

    /**
     * @var string
     */
    private string $errorRoot;

    /**
     * @param ConstraintViolationListInterface $violationList
     * @param string $errorRoot
     */
    public function __construct(ConstraintViolationListInterface $violationList, string $errorRoot)
    {
        parent::__construct('Incorrect data passed to the request', Response::HTTP_BAD_REQUEST);

        $this->violationList = $violationList;
        $this->errorRoot = $errorRoot;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }

    /**
     * @return string
     */
    public function getErrorRoot(): string
    {
        return $this->errorRoot;
    }
}
