<?php

namespace Src\Exceptions;

use Symfony\Component\Config\Definition\Exception\Exception;

class ValidationException extends AppException
{
    /**
     * @var array<string, string> $errors
     */
    private $errors = [];

    /**
     * @param array<string, string> $errors
     */
    public function __construct(
        $errors = [],
        $message = 'Erros de validação',
        $code = 0,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return array<string, string>
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function get(string $att): ?string
    {
        return isset($this->errors[$att]) ? $this->errors[$att] : null;
    }
}
