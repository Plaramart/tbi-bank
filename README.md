# About

This is standalone API wrapper for Bulgarian TBI Bank. Implement as payment method / recurring payment. Ask for
calculations for single/all schemes and more;

# Installation

```bash
composer require plaramart/tbi-bank
```

# Usage

## Initialization

Initialize without framework

```php 
$client = new \Plaramart\TbiBank\Client('your-api-secret', __DIR__.'/folder/pub.pem');
```

Initialize using laravel framework, or you can install my laravel implementation

```php
// Inside AppServiceProvider.php
$this->app->singleton(\Plaramart\TbiBank\Client::class, function () {    
    $apiSecretKey = 'your-api-secret';
    $pathToCert = storage_path('app/pub.pem');
    return new \Plaramart\TbiBank\Client($apiSecretKey, $pathToCert);
});
```

## Get calculation

### all schemes

Get calculations for all schemes. You can only pass first param (price) to get all data you need. Other params are not
mandatory but you can fill them if needed.

```php      
// (float $price, float $initialPayment = 0, int $category = 10, $insurance = 'n')
$calculationRequest = new \Plaramart\TbiBank\Requests\CalculateForAllPeriodSchemesRequest(
    price: 113
);

$response = $client->execute($calculationRequest);
```

### single scheme

Second parameter is $period. That's the specific schema u want e.g calc(price: 113, period: 3)

```php
// (float $price, int $period = 3, float $initialPayment = 0, int $category = 10, $insurance = 'n')
$calculationRequest = new \Plaramart\TbiBank\Requests\CalculateForPeriodRequest(
    price: 113, 
    period: 3
);

$response = $client->execute($calculationRequest);
```

## Submit order to TBI

```php
$order = new CreateOrderRequest(price: 113, months: 3, initialPayment: 50);

$order->setUser(
    name: 'Zgdevv LordGeorgex', 
    id: 9808027528, 
    address: 'Na borovets batko', 
    phone: '+35988888888', 
    email: 'me@gmail.com'
);

// You can add as much as u want products. 
// Product ID from your database. nothing to do with their API
$order->addProduct(
    id: 1, 
    name: 'test', 
    quantity: 2, 
    price: 113
);

$response = $client->execute($order);
```

# Contribution

Send PR for bug fixes or improvements. For contact zgdevv@gmail.com

# License

MIT