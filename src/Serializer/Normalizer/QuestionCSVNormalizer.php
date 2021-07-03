<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\Question;
use App\Service\DatabaseManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class QuestionCSVNormalizer implements NormalizerInterface
{
    /**
     * @param Question $object
     * @param null $format
     * @param array $context
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        $choices = $object->getChoices();

        return [
            'Question text' => $object->getText(),
            'Created At' => $object->getCreatedAt()->format(DatabaseManagerInterface::DATE_TIME_FORMAT),
            'Choice 1' => $choices[0]->getText(),
            'Choice' => $choices[1]->getText(),
            'Choice 3' => $choices[2]->getText(),
        ];
    }

    /**
     * @param mixed $data
     * @param null $format
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $format === 'csv' && $data instanceof Question;
    }
}
