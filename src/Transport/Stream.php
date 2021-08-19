<?php

namespace FastForex\Transport;

use FastForex\Exception\APIException;
use FastForex\TransportInterface;

/**
 * PHP native stream HTTP client implementation
 */
class Stream implements TransportInterface
{

    const REGEX_HTTP_STATUS = "#HTTP/(?<version>[\d\.]+)\s(?<code>\d+)(.*)#";

    /**
     * Fetch a URL, decode and return the response object
     *
     * @param string $url
     * @return \stdClass
     * @throws APIException
     */
    public function fetch($url) {
        $response = @file_get_contents(
            $url,
            false,
            stream_context_create(
                [
                    'http' => [
                        'method' => 'GET',
                        'header' => implode("\r\n", [
                            'User-Agent: fastforex-php-client stream-transport'
                        ]),
                        'ignore_errors' => true,
                        'follow_location' => false,
                        'timeout' => TransportInterface::HTTP_TIMEOUT
                    ],
                    'ssl' => [
                        'verify_peer' => true,
                    ]
                ])
        );

        if (empty($http_response_header)) {
            throw new APIException('HTTP call failed - timeout or no headers');
        }

        if (empty($response)) {
            throw new APIException('HTTP call failed - empty response');
        }

        return $this->validateResponse($response, $http_response_header);
    }

    /**
     * Process HTTP response payload and headers
     *
     * @param string $response
     * @param array $http_response_header
     * @return object
     * @throws APIException
     */
    protected function validateResponse($response, array $http_response_header)
    {
        // Check HTTP response code
        $status_code = 500;
        $response_match = [];
        if (1 === preg_match(self::REGEX_HTTP_STATUS, $http_response_header[0], $response_match)) {
            if (isset($response_match['code'])) {
                $status_code = (int) $response_match['code'];
            }
        }

        // Grab the response
        if ('{' === $response[0] || '[' === $response[0]) {
            $response_object = json_decode($response, false);
        } else {
            $response_object = (object) ['error' => $response];
        }

        // OK?
        if ($status_code >= 200 && $status_code < 300) {
            return $response_object;
        }

        $message = isset($response_object->error) ? $response_object->error : 'Error response';
        throw new APIException($message, $status_code);
    }
}