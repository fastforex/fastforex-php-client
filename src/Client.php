<?php

namespace FastForex;

use FastForex\Transport\Stream;

class Client
{

    const BASE_URL = 'https://api.fastforex.io';

    const
        FETCH_ALL = '/fetch-all',
        FETCH_ONE = '/fetch-one',
        FETCH_MULTI = '/fetch-multi',
        FETCH_USAGE = '/usage',
        FETCH_CONVERT = '/convert',
        FETCH_CURRENCIES = '/currencies';

    /**
     * @var string|null
     */
    protected static $api_key = null;

    /**
     * Set the API key
     *
     * @param string $api_key
     */
    public static function setApiKey($api_key)
    {
        self::$api_key = $api_key;
    }

    /**
     * Fetch all target currency rates, using the supplied currency as the base.
     *
     * @param string $from
     * @return object|\stdClass
     * @throws Exception\APIException
     */
    public function fetchAll($from = 'USD')
    {
        return $this->getTransport()->fetch(
            $this->buildUrl(
                self::FETCH_ALL,
                [
                    'from' => $from,
                ]
            )
        );
    }

    /**
     * Fetch all target currency rates, using the supplied currency as the base.
     *
     * @param string $from
     * @param string $to
     * @return object|\stdClass
     * @throws Exception\APIException
     */
    public function fetchOne($from = 'USD', $to = '')
    {
        if (empty($to)) {
            throw new \InvalidArgumentException('Please supply a target currency');
        }
        return $this->getTransport()->fetch(
            $this->buildUrl(
                self::FETCH_ONE,
                [
                    'from' => $from,
                    'to' => $to,
                ]
            )
        );
    }

    /**
     * Convert an amount of one currency to another
     *
     * @param string $from
     * @param string $to
     * @param int|float $amount
     * @return object|\stdClass
     * @throws Exception\APIException
     */
    public function convert($from = 'USD', $to = '', $amount = 0)
    {
        if (empty($to)) {
            throw new \InvalidArgumentException('Please supply a target currency');
        }
        if (empty($amount)) {
            throw new \InvalidArgumentException('Please supply a valid amount');
        }
        return $this->getTransport()->fetch(
            $this->buildUrl(
                self::FETCH_CONVERT,
                [
                    'from' => $from,
                    'to' => $to,
                    'amount' => $amount
                ]
            )
        );
    }

    /**
     * Fetch several target currency rates, using the supplied currency as the base.
     *
     * @param string $from
     * @param array $to
     * @return object|\stdClass
     * @throws Exception\APIException
     */
    public function fetchMulti($from = 'USD', array $to = [])
    {
        if (empty($to)) {
            throw new \InvalidArgumentException('Please supply a target currency');
        }
        return $this->getTransport()->fetch(
            $this->buildUrl(
                self::FETCH_MULTI,
                [
                    'from' => $from,
                    'to' => implode(',', $to),
                ]
            )
        );
    }

    /**
     * Fetch all supported currencies
     *
     * @return object|\stdClass
     * @throws Exception\APIException
     */
    public function currencies()
    {
        return $this->getTransport()->fetch(
            $this->buildUrl(self::FETCH_CURRENCIES)
        );
    }

    /**
     * Fetch recent API usage
     *
     * @return object|\stdClass
     * @throws Exception\APIException
     */
    public function usage()
    {
        return $this->getTransport()->fetch(
            $this->buildUrl(self::FETCH_USAGE)
        );
    }

    /**
     * Build the best transport
     *
     * @todo Expand to include cURL, PSR
     *
     * @return TransportInterface
     */
    protected function getTransport()
    {
        return new Stream();
    }

    /**
     * Build a base URL, including non-empty API key
     *
     * @param string $action
     * @param array $params
     * @return string
     */
    protected function buildUrl($action, array $params = [])
    {
        if (empty(self::$api_key)) {
            throw new \InvalidArgumentException('API key not set');
        }
        return self::BASE_URL . $action . '?' . http_build_query(
            array_merge(['api_key' => self::$api_key], $params)
        );
    }

}