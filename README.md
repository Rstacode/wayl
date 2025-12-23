# Wayl Laravel Package

<p align="center">
<a href="https://packagist.org/packages/rstacode/wayl"><img src="https://img.shields.io/packagist/v/rstacode/wayl.svg?style=flat-square" alt="Latest Version on Packagist"></a>
<a href="https://packagist.org/packages/rstacode/wayl"><img src="https://img.shields.io/packagist/dt/rstacode/wayl.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/rstacode/wayl"><img src="https://img.shields.io/packagist/l/rstacode/wayl.svg?style=flat-square" alt="License"></a>
</p>

The e-commerce payment platform for Iraq and Middle East. Wayl transforms social media merchants into real businesses.

Wayl provides a simple and powerful Laravel package to create payment links, manage products, handle subscriptions, and process refunds with ease.

## Features

- 🚀 **Payment Links**: Create and manage payment links effortlessly
- 📦 **Products**: Retrieve and manage your product catalog
- 🔄 **Subscriptions**: Handle recurring payments and subscriptions
- 👥 **Subscribers**: Track and manage your subscribers
- 💸 **Refunds**: Process refunds with simple API calls
- 📊 **Channels**: Access available payment channels
- 🔐 **Authentication**: Secure API key verification
- ⚡ **Fast & Reliable**: Optimized for performance
- 🛡️ **Exception Handling**: Comprehensive error handling

## Requirements

- PHP 8.1, 8.2, 8.3, or 8.4
- Laravel 10, 11, or 12

## Installation

Install the package via Composer:

```bash
composer require rstacode/wayl
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=wayl-config
```

Add your Wayl API key to your `.env` file:

```env
WAYL_API_KEY=your_api_key_here
WAYL_BASE_URL=https://api.thewayl.com/api/v1
WAYL_TIMEOUT=30
```

You can get your API key from the [Wayl Dashboard](https://wayl.io).

## Usage

### Verify Authentication Key

Verify your API key is valid:

```php
use Wayl\Facades\Wayl;

$response = Wayl::auth()->verifyKey();
```

**Response:**

```php
[
    'data' => [],
    'message' => 'Authenticated successfully'
]
```

### Get Payment Channels

Retrieve all available payment channels:

```php
use Wayl\Facades\Wayl;

$channels = Wayl::channels()->all();

foreach ($channels['data'] as $channel) {
    echo $channel['name'];
    echo $channel['icon'];
}
```

**Response:**

```php
[
    'data' => [
        [
            'id' => 'channel-123',
            'name' => 'FIB',
            'icon' => 'https://example.com/icon.png'
        ]
    ],
    'message' => 'Success'
]
```

### Create Payment Link

Create a new payment link:

```php
use Wayl\Facades\Wayl;

$response = Wayl::links()->create([
    'referenceId' => 'order-123',
    'total' => 10000,
    'currency' => 'IQD',
    'customParameter' => '',
    'lineItem' => [
        [
            'label' => 'Product Name',
            'amount' => 10000,
            'type' => 'increase',
            'image' => 'https://example.com/product.jpg'
        ]
    ],
    'webhookUrl' => 'https://your-site.com/webhooks/wayl',
    'webhookSecret' => 'your_webhook_secret',
    'redirectionUrl' => 'https://your-site.com/success'
]);

echo $response['data']['url'];
echo $response['data']['code'];
```

**Response:**

```php
[
    'data' => [
        'customParameter' => '',
        'referenceId' => 'order-123',
        'id' => 'cmjicw32o00jnjy089lh5kvri',
        'total' => '10000',
        'currency' => 'IQD',
        'code' => '7G2DG958',
        'paymentMethod' => null,
        'type' => 'Schrödinger',
        'status' => 'Created',
        'completedAt' => null,
        'createdAt' => '2025-12-23T09:01:58.032Z',
        'updatedAt' => '2025-12-23T09:01:58.032Z',
        'url' => 'https://link.thewayl.com/pay?id=cmjicw32o00jnjy089lh5kvri',
        'webhookUrl' => 'https://your-site.com/webhooks/wayl',
        'redirectionUrl' => 'https://your-site.com/success?referenceId=order-123&orderid=cmjicw32o00jnjy089lh5kvri'
    ],
    'message' => 'Done',
    'success' => true
]
```

### Retrieve All Links

Get all payment links with pagination:

```php
use Wayl\Facades\Wayl;

$links = Wayl::links()->all([
    'take' => 10,
    'skip' => 0,
    'statuses' => 'Pending'
]);

foreach ($links['data'] as $link) {
    echo $link['referenceId'];
    echo $link['status'];
    echo $link['total'];
}
```

### Retrieve a Specific Link

Get a specific link by reference ID:

```php
use Wayl\Facades\Wayl;

$link = Wayl::links()->find('order-123');

echo $link['data']['status'];
echo $link['data']['url'];
```

### Invalidate a Link

Invalidate a payment link:

```php
use Wayl\Facades\Wayl;

$response = Wayl::links()->invalidate('order-123');
```

### Invalidate a Link (Only if Pending)

Invalidate a link only if its status is pending:

```php
use Wayl\Facades\Wayl;

$response = Wayl::links()->invalidateIfPending('order-123');
```

### Batch Retrieve Links

Retrieve multiple links by reference IDs:

```php
use Wayl\Facades\Wayl;

$response = Wayl::links()->batch([
    'ref-001',
    'ref-002',
    'ref-003'
]);

echo $response['totalRequested'];
echo $response['totalFound'];
```

**Response:**

```php
[
    'data' => [...],
    'message' => 'Found 2 links out of 3 requested reference IDs',
    'totalRequested' => 3,
    'totalFound' => 2
]
```

### Retrieve All Products

Get all products with pagination:

```php
use Wayl\Facades\Wayl;

$products = Wayl::products()->all([
    'take' => 10,
    'skip' => 0
]);

foreach ($products['data'] as $product) {
    echo $product['name'];
    echo $product['price'];
    echo $product['status'];
}
```

**Response:**

```php
[
    'data' => [
        [
            'id' => 'product-123',
            'name' => 'Product Name',
            'price' => '10000',
            'url' => 'https://example.com/product',
            'status' => 'active',
            'image' => 'https://example.com/image.jpg',
            'tags' => 'tag1,tag2',
            'description' => 'Product description',
            'createdAt' => '2025-12-23T08:42:32.665Z',
            'updatedAt' => '2025-12-23T08:42:32.665Z',
            'productType' => 'physical',
            'qt' => 1,
            'unlimited' => true
        ]
    ],
    'message' => 'Success'
]
```

### Retrieve a Specific Product

Get a product by ID:

```php
use Wayl\Facades\Wayl;

$product = Wayl::products()->find('product-123');

echo $product['data']['name'];
echo $product['data']['price'];
```

### Retrieve All Subscriptions

Get all subscriptions with pagination:

```php
use Wayl\Facades\Wayl;

$subscriptions = Wayl::subscriptions()->all([
    'take' => 10,
    'skip' => 0
]);

foreach ($subscriptions['data'] as $subscription) {
    echo $subscription['title'];
    echo $subscription['amount'];
    echo $subscription['subscriptionPeriod'];
}
```

**Response:**

```php
[
    'data' => [
        [
            'createdAt' => '2025-12-23T08:42:32.665Z',
            'updatedAt' => '2025-12-23T08:42:32.665Z',
            'id' => 'subscription-123',
            'title' => 'Monthly Plan',
            'amount' => '10000',
            'currency' => 'IQD',
            'subscriptionPeriod' => 'Monthly',
            'gracePeriod' => 3,
            'pausedSubscription' => false
        ]
    ],
    'message' => 'Success'
]
```

### Retrieve a Specific Subscription

Get a subscription by ID:

```php
use Wayl\Facades\Wayl;

$subscription = Wayl::subscriptions()->find('subscription-123');

echo $subscription['data']['title'];
echo $subscription['data']['amount'];
```

### Retrieve All Subscribers

Get all subscribers with pagination and filtering:

```php
use Wayl\Facades\Wayl;

$subscribers = Wayl::subscribers()->all([
    'take' => 10,
    'skip' => 0,
    'status' => 'Active'
]);

foreach ($subscribers['data'] as $subscriber) {
    echo $subscriber['status'];
    echo $subscriber['nextBillingAt'];
    echo $subscriber['customer']['name'];
}
```

**Response:**

```php
[
    'data' => [
        [
            'id' => 'subscriber-123',
            'createdAt' => '2025-12-23T08:42:32.665Z',
            'updatedAt' => '2025-12-23T08:42:32.665Z',
            'amount' => 10000,
            'currency' => 'IQD',
            'period' => 'Monthly',
            'status' => 'Active',
            'nextBillingAt' => '2025-01-23T08:42:32.665Z',
            'pendingAmount' => 0,
            'retryCount' => 0,
            'product' => [
                'id' => 'product-123',
                'title' => 'Monthly Plan',
                'price' => 10000,
                'subscriptionPeriod' => 'Monthly'
            ],
            'customer' => [
                'id' => 'customer-123',
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '9647501234567'
            ]
        ]
    ],
    'message' => 'Success'
]
```

### Create a Refund

Create a refund request:

```php
use Wayl\Facades\Wayl;

$response = Wayl::refunds()->create([
    'referenceId' => 'order-123',
    'reason' => 'Customer requested refund',
    'amount' => 5000
]);
```

### Retrieve All Refunds

Get all refunds with filtering:

```php
use Wayl\Facades\Wayl;

$refunds = Wayl::refunds()->all([
    'referenceId' => 'order-123',
    'take' => 10,
    'skip' => 0,
    'statuses' => 'Requested'
]);

foreach ($refunds['data'] as $refund) {
    echo $refund['reason'];
    echo $refund['amount'];
    echo $refund['status'];
}
```

**Response:**

```php
[
    'data' => [
        [
            'id' => 'refund-123',
            'reason' => 'Customer requested refund',
            'linkId' => 'link-123',
            'referenceId' => 'order-123',
            'amount' => 5000,
            'initiatedBy' => 'merchant',
            'status' => 'Requested'
        ]
    ],
    'message' => 'Success'
]
```

### Retrieve a Specific Refund

Get a refund by ID:

```php
use Wayl\Facades\Wayl;

$refund = Wayl::refunds()->find('refund-123');

echo $refund['data']['status'];
echo $refund['data']['amount'];
```

### Cancel a Refund

Cancel a refund request:

```php
use Wayl\Facades\Wayl;

$response = Wayl::refunds()->cancel('refund-123');
```

## Dependency Injection

You can also use dependency injection instead of the Facade:

```php
use Wayl\Wayl;

class PaymentController extends Controller
{
    public function __construct(protected Wayl $wayl)
    {
    }

    public function createPayment()
    {
        return $this->wayl->links()->create([
            'referenceId' => 'order-123',
            'total' => 10000,
            'currency' => 'IQD',
        ]);
    }
}
```

## Error Handling

The package provides comprehensive error handling through the `WaylException` class:

```php
use Wayl\Facades\Wayl;
use Wayl\Exceptions\WaylException;

try {
    $response = Wayl::links()->create([
        'referenceId' => 'order-123',
        'total' => 10000,
        'currency' => 'IQD',
    ]);
} catch (WaylException $e) {
    $message = $e->getMessage();
    $code = $e->getCode();
    $response = $e->getResponse();

    // Handle the error
    logger()->error('Wayl API Error', [
        'message' => $message,
        'code' => $code,
        'response' => $response
    ]);
}
```

### Available Exception Methods

- `getMessage()` - Get the error message
- `getCode()` - Get the HTTP status code
- `getResponse()` - Get the full API response data

## API Reference

### Links

| Method                                     | Description                        |
| ------------------------------------------ | ---------------------------------- |
| `create(array $data)`                      | Create a new payment link          |
| `all(array $params = [])`                  | Retrieve all links with pagination |
| `find(string $referenceId)`                | Retrieve a specific link           |
| `invalidate(string $referenceId)`          | Invalidate a link                  |
| `invalidateIfPending(string $referenceId)` | Invalidate a link if pending       |
| `batch(array $referenceIds)`               | Retrieve multiple links            |

### Products

| Method                    | Description                 |
| ------------------------- | --------------------------- |
| `all(array $params = [])` | Retrieve all products       |
| `find(string $productId)` | Retrieve a specific product |

### Subscriptions

| Method                         | Description                      |
| ------------------------------ | -------------------------------- |
| `all(array $params = [])`      | Retrieve all subscriptions       |
| `find(string $subscriptionId)` | Retrieve a specific subscription |

### Subscribers

| Method                    | Description              |
| ------------------------- | ------------------------ |
| `all(array $params = [])` | Retrieve all subscribers |

### Refunds

| Method                     | Description                |
| -------------------------- | -------------------------- |
| `create(array $data)`      | Create a refund request    |
| `all(array $params = [])`  | Retrieve all refunds       |
| `find(string $refundId)`   | Retrieve a specific refund |
| `cancel(string $refundId)` | Cancel a refund request    |

### Authentication

| Method        | Description        |
| ------------- | ------------------ |
| `verifyKey()` | Verify the API key |

### Channels

| Method  | Description                   |
| ------- | ----------------------------- |
| `all()` | Retrieve all payment channels |

## Support

- **Website**: [wayl.io](https://wayl.io)
- **API Documentation**: [api.thewayl.com](https://api.thewayl.com)
- **Email**: support@wayl.io
- **Issues**: [GitHub Issues](https://github.com/rstacode/wayl/issues)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [Rstacode](https://github.com/rstacode)
- [All Contributors](https://github.com/rstacode/wayl/contributors)
