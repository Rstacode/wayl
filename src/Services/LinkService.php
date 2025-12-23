<?php

namespace Wayl\Services;

use Wayl\Wayl;

class LinkService
{
    protected Wayl $client;

    public function __construct(Wayl $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new payment link.
     *
     * @param array{
     *     referenceId: string,
     *     total: int,
     *     currency: string,
     *     customParameter?: string,
     *     lineItem?: array<int, array{label: string, amount: int, type: string, image?: string}>,
     *     webhookUrl?: string,
     *     webhookSecret?: string,
     *     redirectionUrl?: string
     * } $data
     */
    public function create(array $data): array
    {
        return $this->client->post('links', $data);
    }

    /**
     * Retrieve all links with pagination and filtering.
     *
     * @param array{take?: int, skip?: int, statuses?: string} $params
     */
    public function all(array $params = []): array
    {
        return $this->client->get('links', $params);
    }

    /**
     * Retrieve a specific link by reference ID.
     */
    public function find(string $referenceId): array
    {
        return $this->client->get("links/{$referenceId}");
    }

    /**
     * Invalidate a specific link.
     */
    public function invalidate(string $referenceId): array
    {
        return $this->client->post("links/{$referenceId}/invalidate");
    }

    /**
     * Invalidate a specific link only if it is pending.
     */
    public function invalidateIfPending(string $referenceId): array
    {
        return $this->client->post("links/{$referenceId}/invalidate-if-pending");
    }

    /**
     * Retrieve a group of links by reference IDs.
     *
     * @param array<int, string> $referenceIds
     */
    public function batch(array $referenceIds): array
    {
        return $this->client->post('links/batch', [
            'referenceIds' => $referenceIds,
        ]);
    }
}
