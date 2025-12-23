<?php

namespace Wayl\Facades;

use Illuminate\Support\Facades\Facade;
use Wayl\Services\AuthService;
use Wayl\Services\ChannelService;
use Wayl\Services\LinkService;
use Wayl\Services\ProductService;
use Wayl\Services\RefundService;
use Wayl\Services\SubscriberService;
use Wayl\Services\SubscriptionService;

/**
 * @method static AuthService auth()
 * @method static ChannelService channels()
 * @method static LinkService links()
 * @method static ProductService products()
 * @method static SubscriptionService subscriptions()
 * @method static SubscriberService subscribers()
 * @method static RefundService refunds()
 * @method static array get(string $endpoint, array $query = [])
 * @method static array post(string $endpoint, array $data = [])
 * @method static array delete(string $endpoint)
 *
 * @see \Wayl\Wayl
 */
class Wayl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wayl\Wayl::class;
    }
}

