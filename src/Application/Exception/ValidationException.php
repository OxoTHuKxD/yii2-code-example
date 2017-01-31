<?php

namespace BannerService\Application\Exception;

class ValidationException extends \Exception
{
    /** @var array */
    private $errors;

    /**
     * ValidationException constructor.
     * @param array $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}