<?php

namespace Wayl\Exceptions;

use Exception;

class WaylException extends Exception
{
    protected array $response;

    public function __construct(string $message = '', int $code = 0, array $response = [])
    {
        parent::__construct($message, $code);
        $this->response = $response;
    }

    /**
     * Get the API response data.
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * Create exception from API response.
     */
    public static function fromResponse(array $response, int $statusCode = 400): self
    {
        $message = $response['message'] ?? 'An error occurred with the Wayl API';

        return new self($message, $statusCode, $response);
    }
}
