<?php

namespace DavidZadrazil\AirtableApi;

use GuzzleHttp\Client;

/**
 * Class Request
 *
 * @package DavidZadrazil
 */
abstract class Request
{
    /**
     * @var Airtable
     */
    protected $airtable;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Request constructor.
     *
     * @param Airtable $airtable
     */
    public function __construct(Airtable $airtable)
    {
        $this->airtable = $airtable;

        // Initialize Guzzle client
        $this->client = new Client(
            [
                'base_uri' => $this->getRequestUrl(),
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $airtable->getApiKey())
                ]
            ]
        );
    }

    /**
     * @return string
     */
    abstract protected function getRequestUrl(): string;
}
