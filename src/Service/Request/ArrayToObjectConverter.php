<?php

declare(strict_types=1);

namespace App\Service\Request;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ArrayToObjectConverter
{
    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;

    /**
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    /**
     * @param array $data
     * @param string $type
     *
     * @return object
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function transform(array $data, string $type): object
    {
        return $this->denormalizer->denormalize($data, $type, null, [
            ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
        ]);
    }
}
