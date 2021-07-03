<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Choice;
use App\Entity\Question;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionDenormalizer implements DenormalizerInterface, NestedFormatDenormalizerInterface
{
    private SerializerInterface $serializer;

    /**
     * @required
     *
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $data
     * @param string $type
     * @param null $format
     * @param array $context
     *
     * @return Question
     */
    public function denormalize($data, $type, $format = null, array $context = []): Question
    {
        $choices = $this->serializer->denormalize($data['choices'], Choice::class.'[]', $format, $context);

        return new Question($data['text'], new \DateTimeImmutable($data['createdAt']), $choices);
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
        return in_array($format,self::NESTED_FORMATS, true) && $type === Question::class;
    }
}
