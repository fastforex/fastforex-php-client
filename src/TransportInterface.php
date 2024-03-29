<?php

namespace FastForex;

interface TransportInterface
{

    const HTTP_TIMEOUT = 2;

    /**
     * Make an API call, return the response object
     *
     * @param string $url
     * @return \stdClass
     */
    public function fetch($url);

}