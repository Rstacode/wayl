<?php

namespace Wayl;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Wayl\Exceptions\WaylException;
use Wayl\Services\AuthService;
use Wayl\Services\ChannelService;
use Wayl\Services\LinkService;
use Wayl\Services\ProductService;
use Wayl\Services\RefundService;
use Wayl\Services\SubscriberService;
use Wayl\Services\SubscriptionService;

class Wayl
{
    protected Client $client;
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(?string $apiKey = null, ?string $baseUrl = null)
    {
        $this->apiKey = $apiKey ?? config('wayl.api_key', '');
        $this->baseUrl = $baseUrl ?? config('wayl.base_url', 'https://api.thewayl.com/api/v1');

        // Ensure base URL ends with a trailing slash for proper Guzzle path resolution
        if (!str_ends_with($this->baseUrl, '/')) {
            $this->baseUrl .= '/';
        }

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => config('wayl.timeout', 30),
            'headers' => [
                'X-WAYL-AUTHENTICATION' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Make a GET request to the API.
     *
     * @throws WaylException
     */
    public function get(string $endpoint, array $query = []): array
    {
        return $this->request('GET', $endpoint, ['query' => $query]);
    }

    /**
     * Make a POST request to the API.
     *
     * @throws WaylException
     */
    public function post(string $endpoint, array $data = []): array
    {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }

    /**
     * Make a DELETE request to the API.
     *
     * @throws WaylException
     */
    public function delete(string $endpoint): array
    {
        return $this->request('DELETE', $endpoint);
    }

    /**
     * Make an HTTP request to the API.
     *
     * @throws WaylException
     */
    protected function request(string $method, string $endpoint, array $options = []): array
    {
        try {
            $response = $this->client->request($method, $endpoint, $options);
            $body = json_decode($response->getBody()->getContents(), true);

            return $body ?? [];
        } catch (GuzzleException $e) {
            $response = [];
            $statusCode = 500;

            if (method_exists($e, 'getResponse') && $e->getResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                $body = $e->getResponse()->getBody()->getContents();
                $response = json_decode($body, true) ?? [];
            }

            throw WaylException::fromResponse(
                array_merge($response, ['error' => $e->getMessage()]),
                $statusCode
            );
        }
    }

    /**
     * Get the Auth service.
     */
    public function auth(): AuthService
    {
        return new AuthService($this);
    }

    /**
     * Get the Channels service.
     */
    public function channels(): ChannelService
    {
        return new ChannelService($this);
    }

    /**
     * Get the Links service.
     */
    public function links(): LinkService
    {
        return new LinkService($this);
    }

    /**
     * Get the Products service.
     */
    public function products(): ProductService
    {
        return new ProductService($this);
    }

    /**
     * Get the Subscriptions service.
     */
    public function subscriptions(): SubscriptionService
    {
        return new SubscriptionService($this);
    }

    /**
     * Get the Subscribers service.
     */
    public function subscribers(): SubscriberService
    {
        return new SubscriberService($this);
    }

    /**
     * Get the Refunds service.
     */
    public function refunds(): RefundService
    {
        return new RefundService($this);
    }
}
