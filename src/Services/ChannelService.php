<?php

namespace Wayl\Services;

use Wayl\Wayl;

class ChannelService
{
    protected Wayl $client;

    public function __construct(Wayl $client)
    {
        $this->client = $client;
    }

    /**
     * Get all available channels.
     *
     * @return array{data: array<int, array{id: string, name: string, icon: string}>, message: string}
     */
    public function all(): array
    {
        return $this->client->get('channels');
    }
}
