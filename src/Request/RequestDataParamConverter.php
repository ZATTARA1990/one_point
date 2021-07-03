<?php

declare(strict_types=1);

namespace App\Request;

use App\Service\Request\ArrayToObjectConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class looks for Controller params that implement RequestDataInterface.
 *
 * Then it gets data from specified part of the request or from the default one.
 * Default is dependent on the request's HTTP method.
 *
 * Then it uses ArrayToObjectConverter to convert data to an object of the needed class.
 */
class RequestDataParamConverter implements ParamConverterInterface
{
    public const FROM_ANY = 'any';
    public const FROM_QUERY = 'query';
    public const FROM_BODY = 'body';

    /**
     * @var ArrayToObjectConverter
     */
    private ArrayToObjectConverter $arrayToObjectConverter;

    /**
     * @param ArrayToObjectConverter $arrayToObjectTransformer
     */
    public function __construct(ArrayToObjectConverter $arrayToObjectTransformer)
    {
        $this->arrayToObjectConverter = $arrayToObjectTransformer;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     *
     * @return bool
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $dataSource = $this->getRequestDataSource(
            $request,
            $configuration->getOptions()['from'] ?? self::FROM_ANY
        );

        $data = $this->getRequestData($request, $dataSource);


        $requestDataObject = $this->arrayToObjectConverter->transform($data, $configuration->getClass());

        $request->attributes->set($configuration->getName(), $requestDataObject);

        return true;
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return is_subclass_of($configuration->getClass(), RequestDataInterface::class);
    }

    /**
     * @param Request $request
     * @param string $dataSource
     *
     * @return array
     */
    private function getRequestData(Request $request, string $dataSource): array
    {
        return $dataSource === self::FROM_BODY ? $request->request->all() : $request->query->all();
    }

    /**
     * @param Request $request
     * @param string $from
     *
     * @return string
     */
    private function getRequestDataSource(Request $request, string $from): string
    {
        if (!in_array($from, [
            self::FROM_ANY,
            self::FROM_BODY,
            self::FROM_QUERY,
        ], true)) {
            throw new \LogicException('Unsupported "from" option used.');
        }

        if ($from === self::FROM_ANY) {
            $from = $request->getMethod() === Request::METHOD_GET ? self::FROM_QUERY : self::FROM_BODY;
        }

        return $from;
    }
}
