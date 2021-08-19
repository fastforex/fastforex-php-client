<?php

namespace FastForex\Tests;

use FastForex\Client;
use FastForex\Tests\Stub\Transport;

class ClientFailureTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Make sure we throw when there is no APi key set
     */
    public function testNoApiKey()
    {
        $obj_client = new Client();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('API key not set');
        $obj_client->usage();
    }

    /**
     * Make sure we throw when parameters are missing
     */
    public function testFetchOneEmptyTarget()
    {
        $obj_client = new Client();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Please supply a target currency');
        $obj_client->fetchOne('GBP');
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Please supply a target currency');
        $obj_client->fetchOne('GBP', '');
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Please supply a target currency');
        $obj_client->fetchOne('GBP', 0);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Please supply a target currency');
        $obj_client->fetchOne('GBP', null);
    }


}
