<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationListNormalizer implements NormalizerInterface
{
    public const ERROR_ROOT = 'error_root';

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        if (!$object instanceof ConstraintViolationListInterface) {
            throw new \LogicException('Unexpected class passed');
        }

        return array_values(
            array_map(fn (ConstraintViolationInterface $violation): array => $this->createFieldError(
                $violation->getPropertyPath(),
                $violation->getMessage(),
                $context[self::ERROR_ROOT] ?? null,
            ), iterator_to_array($object))
        );
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array|null $context
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null, array $context = null): bool
    {
        return $data instanceof ConstraintViolationListInterface;
    }

    /**
     * @param string $field
     * @param string $message
     * @param string|null $root
     *
     * @return array
     */
    private function createFieldError(string $field, string $message, ?string $root = null): array
    {
        $delimiter = ($field !== '' && $root !== null) ? '.' : '';

        $field = sprintf('%s%s%s', $root, $delimiter, $field);

        return [
            'field' => $field,
            'message' => $message,
        ];
    }
}
