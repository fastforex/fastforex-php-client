# fastFOREX Currency Exchange Rate API Client
You'll need an API key to use the API client. [Get a FREE API Key](https://console.fastforex.io).

## Quick Start
Set the API key once in your bootstrap code. 
```php
\FastForex\Client::setApiKey('YOUR_API_KEY');
```

Fetch all currencies, with `USD` base:
```php
$response = (new FastForex\Client())->fetchAll('USD');
print_r($response);
```
```
stdClass Object
(
    [base] => USD
    [results] => stdClass Object
        (
            [AED] => 3.67246
            [AFN] => 77.19882
            [ALL] => 101.68772
            ...
        )

    [updated] => 2021-02-15 22:13:51
    [ms] => 5
)
```
## More Examples

Fetch `GBP`, with `USD` base:
```php
$response = (new FastForex\Client())->fetchOne('USD', 'GBP');
echo $response->result->GBP;
```

Fetch several currencies with `USD` base:
```php
$response = (new FastForex\Client())->fetchMulti('USD', ['GBP', 'EUR', 'CHF']);
```

Convert 200 `USD` to `GBP`:
```php
$response = (new FastForex\Client())->convert('USD', 'GBP', 199.99);
```

Fetch a list of supported currencies
```php
$response = (new FastForex\Client())->currencies();
```

Fetch recent API usage
```php
$response = (new FastForex\Client())->usage();
```

## Error Handling

We throw the following Exceptions:

### `\InvalidArgumentException`
Usually when input parameters to the client are wrong

### `\FastForex\Exception\APIException`
When there is problem making the API call, or when there is an error response from the server.

We include the HTTP response code and error message wherever possible:

```php
try {
    \FastForex\Client::setApiKey('invalid key');
    $response = (new FastForex\Client())->fetchAll('USD');
} catch (\FastForex\Exception\APIException $exception) {
    echo $exception->getMessage(), PHP_EOL;
}
```

## Free Plan Restrictions

**Please note: USD is the only supported base currency on the free plan**

**Please note: `convert()` is not available on the free plan**

## API Documentation

This client implements our OpenAPI spec. Interactive documentation available:

* **ReadMe** - https://fastforex.readme.io
* **SwaggerHub** - https://app.swaggerhub.com/apis/fastforex/fastFOREX.io

### OpenAPI Spec
https://github.com/fastforex/openapi