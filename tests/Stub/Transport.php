<?php

namespace FastForex\Tests\Stub;

use FastForex\TransportInterface;

class Transport implements TransportInterface
{

    /**
     * @var string|null
     */
    private $last_url = null;

    /**
     * @var \stdClass|null
     */
    private $next_response = null;

    /**
     * Make an API call, return the response object
     *
     * @param string $url
     * @return \stdClass
     */
    public function fetch($url) {
        $this->last_url = $url;
        $response = $this->next_response;
        $this->next_response = null;
        return $response;
    }

    /**
     * Get the last URL passed to fetch()
     *
     * @return string|null
     */
    public function getLastUrl()
    {
        $url = $this->last_url;
        $this->last_url = null;
        return $url;
    }

    /**
     * Set the response to return the next time fetch() is called
     *
     * @param \stdClass $response
     * @return self
     */
    public function setNextResponse(\stdClass $response)
    {
        $this->next_response = $response;
        return $this;
    }
}