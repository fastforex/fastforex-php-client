<?php

namespace FastForex\Tests;

use FastForex\Client;
use FastForex\Tests\Stub\Transport;

class ClientUrlTest extends \PHPUnit\Framework\TestCase
{

    private function assertResponsePayload($method, $obj_response)
    {
        $this->assertIsObject($obj_response);
        $this->assertObjectHasAttribute('test', $obj_response);
        $this->assertEquals($method, $obj_response->test);
    }

    /**
     * Test URL construction for fetch-all
     */
    public function testFetchAllUrl()
    {
        Client::setApiKey('test_key_1');
        $obj_client = new Client();
        $obj_transport = (new Transport())->setNextResponse((object)['test' => __METHOD__]);
        $obj_client->setTransport($obj_transport);
        $obj_response = $obj_client->fetchAll();
        $this->assertEquals(
            'https://api.fastforex.io/fetch-all?api_key=test_key_1&from=USD',
            $obj_transport->getLastUrl()
        );
        $this->assertResponsePayload(__METHOD__, $obj_response);
    }

    /**
     * Test URL construction for fetch-one
     */
    public function testFetchOneUrl()
    {
        Client::setApiKey('test_key_2');
        $obj_client = new Client();
        $obj_transport = (new Transport())->setNextResponse((object)['test' => __METHOD__]);
        $obj_client->setTransport($obj_transport);
        $obj_response = $obj_client->fetchOne('GBP', 'EUR');
        $this->assertEquals(
            'https://api.fastforex.io/fetch-one?api_key=test_key_2&from=GBP&to=EUR',
            $obj_transport->getLastUrl()
        );
        $this->assertResponsePayload(__METHOD__, $obj_response);
    }

    /**
     * Test URL construction for fetch-multi
     */
    public function testFetchMultiUrl()
    {
        Client::setApiKey('test_key_3');
        $obj_client = new Client();
        $obj_transport = (new Transport())->setNextResponse((object)['test' => __METHOD__]);
        $obj_client->setTransport($obj_transport);
        $obj_response = $obj_client->fetchMulti('EUR', ['CHF','USD','GBP']);
        $this->assertEquals(
            'https://api.fastforex.io/fetch-multi?api_key=test_key_3&from=EUR&to=CHF%2CUSD%2CGBP',
            $obj_transport->getLastUrl()
        );
        $this->assertResponsePayload(__METHOD__, $obj_response);
    }

    /**
     * Test URL construction for historical with target currencies
     */
    public function testHistoricalUrlWithTo()
    {
        Client::setApiKey('test_key_3b');
        $obj_client = new Client();
        $obj_transport = (new Transport())->setNextResponse((object)['test' => __METHOD__]);
        $obj_client->setTransport($obj_transport);
        $obj_date = new \DateTime('-10 days');
        $obj_response = $obj_client->historical($obj_date, 'EUR', ['CHF','USD','GBP']);
        $this->assertEquals(
            sprintf('https://api.fastforex.io/historical?api_key=test_key_3b&date=%s&from=EUR&to=CHF%%2CUSD%%2CGBP', $obj_date->format('Y-m-d')),
            $obj_transport->getLastUrl()
        );
        $this->assertResponsePayload(__METHOD__, $obj_response);
    }

    /**
     * Test URL construction for historical WITHOUT target currencies
     */
    public function testHistoricalUrlWithoutTo()
    {
        Client::setApiKey('test_key_3c');
        $obj_client = new Client();
        $obj_transport = (new Transport())->setNextResponse((object)['test' => __METHOD__]);
        $obj_client->setTransport($obj_transport);
        $obj_date = new \DateTime('-15 days');
        $obj_response = $obj_client->historical($obj_date, 'GBP');
        $this->assertEquals(
            sprintf('https://api.fastforex.io/historical?api_key=test_key_3c&date=%s&from=GBP', $obj_date->format('Y-m-d')),
            $obj_transport->getLastUrl()
        );
        $this->assertResponsePayload(__METHOD__, $obj_response);
    }

    /**
     * Test URL construction for fetch usage
     */
    public function testFetchUsageUrl()
    {
        Client::setApiKey('test_key_4');
        $obj_client = new Client();
        $obj_transport = (new Transport())->setNextResponse((object)['test' => __METHOD__]);
        $obj_client->setTransport($obj_transport);
        $obj_response = $obj_client->usage();
        $this->assertEquals(
            'https://api.fastforex.io/usage?api_key=test_key_4',
            $obj_transport->getLastUrl()
        );
        $this->assertResponsePayload(__METHOD__, $obj_response);
    }

    /**
     * Test URL construction for fetch usage
     */
    public function testFetchCurrencyUrl()
    {
        Client::setApiKey('test_key_5');
        $obj_client = new Client();
        $obj_transport = (new Transport())->setNextResponse((object)['test' => __METHOD__]);
        $obj_client->setTransport($obj_transport);
        $obj_response = $obj_client->currencies();
        $this->assertEquals(
            'https://api.fastforex.io/currencies?api_key=test_key_5',
            $obj_transport->getLastUrl()
        );
        $this->assertResponsePayload(__METHOD__, $obj_response);
    }

    /**
     * Test URL construction for fetch usage
     */
    public function testConvertUrl()
    {
        Client::setApiKey('test_key_6');
        $obj_client = new Client();
        $obj_transport = (new Transport())->setNextResponse((object)['test' => __METHOD__]);
        $obj_client->setTransport($obj_transport);
        $obj_response = $obj_client->convert('CHF', 'EUR', 47.99);
        $this->assertEquals(
            'https://api.fastforex.io/convert?amount=47.99&api_key=test_key_6&from=CHF&to=EUR',
            $obj_transport->getLastUrl()
        );
        $this->assertResponsePayload(__METHOD__, $obj_response);
    }
}