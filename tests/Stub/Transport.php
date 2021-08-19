<?php

namespace FastForex\Tests\Stub;

use FastForex\TransportInterface;

class Transport implements TransportInterface
{

    private $last_url = null;

    /**
     * Make an API call, return the response object
     *
     * @param string $url
     * @return \stdClass
     */
    public function fetch($url) {
        $this->last_url = $url;
        return (object) [];
    }

    public function getLastUrl()
    {
        $url = $this->last_url;
        $this->last_url = null;
        return $url;
    }
}