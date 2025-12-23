<?php

namespace Wayl\Services;

use Wayl\Wayl;

class SubscriptionService
{
    protected Wayl $client;

    public function __construct(Wayl $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve all subscriptions with pagination.
     *
     * @param array{take?: int, skip?: int} $params
     */
    public function all(array $params = []): array
    {
        return $this->client->get('/subscriptions', $params);
    }

    /**
     * Retrieve a specific subscription by ID.
     */
    public function find(string $subscriptionId): array
    {
        return $this->client->get("/subscriptions/{$subscriptionId}");
    }
}

