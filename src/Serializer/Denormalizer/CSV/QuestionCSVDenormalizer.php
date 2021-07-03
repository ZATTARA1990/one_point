<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer\CSV;

use App\Entity\Choice;
use App\Entity\Question;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionCSVDenormalizer implements DenormalizerInterface
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
        $rawChoices = array_values(array_filter($data, static function (string $key): bool {
            return 0 === strpos($key, 'Choice');
        }, ARRAY_FILTER_USE_KEY));

        $choices = $this->serializer->denormalize($rawChoices, Choice::class.'[]', $format, $context);

        return new Question($data['Question text'], new \DateTimeImmutable($data['Created At']), $choices);
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
        return $format === 'csv' && $type === Question::class;
    }
}
