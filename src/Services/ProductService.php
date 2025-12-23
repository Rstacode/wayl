<?php

namespace Wayl\Services;

use Wayl\Wayl;

class ProductService
{
    protected Wayl $client;

    public function __construct(Wayl $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve all products with pagination.
     *
     * @param array{take?: int, skip?: int} $params
     */
    public function all(array $params = []): array
    {
        return $this->client->get('products', $params);
    }

    /**
     * Retrieve a specific product by ID.
     */
    public function find(string $productId): array
    {
        return $this->client->get("products/{$productId}");
    }
}

