<?php

namespace Wayl\Services;

use Wayl\Wayl;

class RefundService
{
    protected Wayl $client;

    public function __construct(Wayl $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new refund request.
     *
     * @param array{referenceId: string, reason: string, amount: int} $data
     */
    public function create(array $data): array
    {
        return $this->client->post('refunds', $data);
    }

    /**
     * Retrieve all refunds with pagination and filtering.
     *
     * @param array{referenceId?: string, take?: int, skip?: int, statuses?: string} $params
     */
    public function all(array $params = []): array
    {
        return $this->client->get('refunds', $params);
    }

    /**
     * Retrieve a specific refund by ID.
     */
    public function find(string $refundId): array
    {
        return $this->client->get("refunds/{$refundId}");
    }

    /**
     * Cancel a specific refund.
     */
    public function cancel(string $refundId): array
    {
        return $this->client->delete("refunds/{$refundId}/cancel");
    }
}

