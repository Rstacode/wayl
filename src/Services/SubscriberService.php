<?php

namespace Wayl\Services;

use Wayl\Wayl;

class SubscriberService
{
    protected Wayl $client;

    public function __construct(Wayl $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve all subscribers with pagination and filtering.
     *
     * @param array{take?: int, skip?: int, status?: string} $params
     */
    public function all(array $params = []): array
    {
        return $this->client->get('/subscribers', $params);
    }
}

