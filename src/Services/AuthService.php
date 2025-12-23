<?php

namespace Wayl\Services;

use Wayl\Wayl;

class AuthService
{
    protected Wayl $client;

    public function __construct(Wayl $client)
    {
        $this->client = $client;
    }

    /**
     * Verify the authentication key.
     *
     * @return array{data: array, message: string}
     */
    public function verifyKey(): array
    {
        return $this->client->get('/verify-auth-key');
    }
}

