<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ListQuestionsQueryDTO;
use App\DTO\QuestionRequestDTO;
use App\Exception\Request\BadRequestException;
use App\Handler\QuestionCreationHandler;
use App\Handler\QuestionsListHandler;
use App\Request\RequestDataParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionController extends AbstractController
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @Route("/questions", name="create_questions", methods={"POST"})
     *
     * @param QuestionRequestDTO $questionRequestDTO
     * @param QuestionCreationHandler $handler
     *
     * @return Response
     *
     * @throws BadRequestException
     */
    public function createQuestion(QuestionRequestDTO $questionRequestDTO, QuestionCreationHandler $handler): Response
    {
        $violationList = $this->validator->validate($questionRequestDTO);
        if ($violationList->count() !== 0) {
            throw new BadRequestException($violationList, RequestDataParamConverter::FROM_BODY);
        }

        $question = $handler->handle($questionRequestDTO);

        return $this->json($question);
    }

    /**
     * @Route("/questions", name="list_questions", methods={"GET"})
     *
     * @param ListQuestionsQueryDTO $listQuestionsQueryDTO
     * @param QuestionsListHandler $handler
     *
     * @return Response
     *
     * @throws BadRequestException
     */
    public function listQuestion(ListQuestionsQueryDTO $listQuestionsQueryDTO, QuestionsListHandler $handler): Response
    {
        $violationList = $this->validator->validate($listQuestionsQueryDTO);
        if ($violationList->count() !== 0) {
            throw new BadRequestException($violationList, RequestDataParamConverter::FROM_QUERY);
        }

        return $this->json([
            'data' => $handler->handle(),
        ], Response::HTTP_OK, [], ['lang' => $listQuestionsQueryDTO->lang]);
    }
}
