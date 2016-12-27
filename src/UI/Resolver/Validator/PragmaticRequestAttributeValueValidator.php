<?php
declare(strict_types=1);

namespace Imedia\Ammit\UI\Resolver\Validator;

use Imedia\Ammit\UI\Resolver\Exception\CommandMappingException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @deprecated Contains Domain Validation assertions (but class won't be removed in next version)
 *   Domain Validation should be done in Domain
 *   Should be used for prototyping project knowing you are accumulating technical debt
 *
 * @author Guillaume MOREL <g.morel@imediafrance.fr>
 */
class PragmaticRequestAttributeValueValidator extends RequestAttributeValueValidator
{
    /** @var RawValueValidator */
    protected $rawValueValidator;

    public function __construct(PragmaticRawValueValidator $rawValueValidator)
    {
        $this->rawValueValidator = $rawValueValidator;
    }

    /**
     * Exceptions are caught in order to be processed later
     *
     * @throws CommandMappingException If any mapping validation failed
     * @return mixed Untouched value
     */
    public function mustBeUuid(ServerRequestInterface $request, string $attributeKey, string $exceptionMessage = null)
    {
        $value = $this->extractValueFromRequestAttribute($request, $attributeKey);

        return $this->rawValueValidator->mustBeUuid(
            $value,
            $attributeKey,
            $exceptionMessage
        );
    }
}