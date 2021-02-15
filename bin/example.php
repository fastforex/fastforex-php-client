<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    FastForex\Client::setApiKey('YOUR_API_KEY');

    // All
    $response = (new FastForex\Client())->fetchAll('USD');

    // One
    // $response = (new FastForex\Client())->fetchOne('USD', 'GBP');

    // Multi
    // $response = (new FastForex\Client())->fetchMulti('USD', ['GBP', 'EUR', 'ZAR']);

    // Convert
    // $response = (new FastForex\Client())->convert('USD', 'GBP', 199.99);

    // Currencies
    // $response = (new FastForex\Client())->currencies();

    // Usage
    // $response = (new FastForex\Client())->usage();

    // Output
    print_r($response);

} catch (\FastForex\Exception\APIException $exception) {
    echo 'API failed with: ', $exception->getMessage(), PHP_EOL;
} catch (\Exception $exception) {
    echo 'Unexpected ', get_class($exception), ' ', $exception->getMessage(), PHP_EOL;
}