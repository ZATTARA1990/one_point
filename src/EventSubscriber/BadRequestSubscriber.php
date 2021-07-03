<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\Request\BadRequestException;
use App\Serializer\Normalizer\ConstraintViolationListNormalizer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BadRequestSubscriber implements EventSubscriberInterface
{
    private const PRIORITY = 16;

    /**
     * @var ConstraintViolationListNormalizer
     */
    private ConstraintViolationListNormalizer $violationListNormalizer;

    /**
     * @param ConstraintViolationListNormalizer $violationListNormalizer
     */
    public function __construct(ConstraintViolationListNormalizer $violationListNormalizer)
    {
        $this->violationListNormalizer = $violationListNormalizer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', self::PRIORITY],
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof BadRequestException) {
            return;
        }

        $event->setResponse(new JsonResponse([
            'status' => 'error',
            'message' => 'validation_error',
            'errors' => $this->violationListNormalizer->normalize($exception->getViolationList(), null, [
                ConstraintViolationListNormalizer::ERROR_ROOT => $exception->getErrorRoot(),
            ]),
        ], Response::HTTP_BAD_REQUEST));
    }
}
