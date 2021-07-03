<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer\Translation;

use App\Entity\Question;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class QuestionTranslationNormalizer implements ContextAwareNormalizerInterface
{
    /**
     * @var GoogleTranslate
     */
    private GoogleTranslate $translator;

    /**
     * @var ObjectNormalizer
     */
    private ObjectNormalizer $objectNormalizer;

    /**
     * @param ObjectNormalizer $objectNormalizer
     */
    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->translator = new GoogleTranslate('en', 'en');
        $this->objectNormalizer = $objectNormalizer;
    }

    /**
     * @param Question $object
     * @param null $format
     * @param array $context
     *
     * @return array
     *
     * @throws \ErrorException
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        $data = $this->objectNormalizer->normalize($object, $format, $context);

        $this->translator->setTarget($context['lang']);

        $data['text'] = $this->translator->translate($data['text']);

        return $data;
    }

    /**
     * @param mixed $data
     * @param null $format
     * @param array $context
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return isset($context['lang']) && $data instanceof Question;
    }
}
