<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Choice;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ChoiceDenormalizer implements DenormalizerInterface
{
    /**
     * @param array $data
     * @param string $type
     * @param null $format
     * @param array $context
     *
     * @return Choice
     */
    public function denormalize($data, $type, $format = null, array $context = []): Choice
    {
        return new Choice($data['text']);
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param null $format
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $format !== 'csv' && $type === Choice::class;
    }
}
