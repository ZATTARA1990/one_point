<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer\Translation;

use App\Entity\Choice;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ChoiceTranslationNormalizer implements ContextAwareNormalizerInterface
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
     * @param Choice $object
     * @param null $format
     * @param array $context
     *
     * @return array
     *
     * @throws \ErrorException|ExceptionInterface
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
        return isset($context['lang']) && $data instanceof Choice;
    }
}
