<?php

namespace Imedia\Ammit\UI\Resolver\Validator\Implementation\Pure;

use Imedia\Ammit\UI\Resolver\Validator\InvalidArgumentException;
use Imedia\Ammit\UI\Resolver\UIValidationEngine;
use Imedia\Ammit\UI\Resolver\Validator\UIValidatorInterface;

/**
 * @author Guillaume MOREL <g.morel@imediafrance.fr>
 */
trait IntegerValidatorTrait
{
    /** @var UIValidationEngine */
    protected $validationEngine;

    /**
     * Exceptions are caught in order to be processed later
     * @param mixed $value Integer ?
     *
     * @return int|null Value casted into int or -1 or null
     */
    public function mustBeIntegerOrEmpty($value, string $propertyPath = null, UIValidatorInterface $parentValidator = null, string $exceptionMessage = null)
    {
        if ($value === '') {
            return null;
        }

        return $this->mustBeInteger($value, $propertyPath, $parentValidator, $exceptionMessage);
    }

    /**
     * Exceptions are caught in order to be processed later
     * @param mixed $value Integer ?
     *
     * @return int Value casted into int or -1
     */
    public function mustBeInteger($value, string $propertyPath = null, UIValidatorInterface $parentValidator = null, string $exceptionMessage = null): int
    {
        if (is_numeric($value)) {
            $value = (int) $value;
        }

        $this->validationEngine->validateFieldValue(
            $parentValidator ?: $this,
            function() use ($value, $propertyPath, $exceptionMessage) {
                if (is_int($value)) {
                    return;
                }

                if (null === $exceptionMessage) {
                    $exceptionMessage = sprintf(
                        'Value "%s" is not an integer.',
                        $value
                    );
                }

                throw new InvalidArgumentException(
                    $exceptionMessage,
                    0,
                    $propertyPath,
                    $value
                );
            }
        );

        if (!is_int($value)) {
            return -1;
        }

        return $value;
    }
}
