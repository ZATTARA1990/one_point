<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Transforms the body of a json request to POST parameters.
 */
class JsonRequestTransformerListener
{
    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (!$this->isJsonRequest($request)) {
            return;
        }

        /** @var string */
        $content = $request->getContent();
        if ($content === '') {
            return;
        }

        if (!$this->transformJsonBody($request)) {
            $response = Response::create('Unable to parse request.', Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function isJsonRequest(Request $request): bool
    {
        return $request->getContentType() === 'json';
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function transformJsonBody(Request $request): bool
    {
        /** @var string $content */
        $content = $request->getContent();
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if ($data === null) {
            return true;
        }

        $request->request->replace($data);

        return true;
    }
}
