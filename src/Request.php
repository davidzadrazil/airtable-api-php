<?php

namespace DavidZadrazil\AirtableApi;

use GuzzleHttp\Client;

/**
 * Class Request
 *
 * @package DavidZadrazil
 */
class Request
{
	/**
	 * @var Airtable
	 */
	private $airtable;

	/**
	 * @var string
	 */
	private $table;

	/**
	 * @var Client
	 */
	private $client;

	/**
	 * @var null|string
	 */
	private $offset = null;

	/**
	 * @var array
	 */
	private $parameters = [];


	/**
	 * Request constructor.
	 *
	 * @param Airtable $airtable
	 * @param $table
	 */
	public function __construct(Airtable $airtable, $table)
	{
		$this->airtable = $airtable;
		$this->table = $table;

		// Initialize Guzzle client
		$this->client = new Client(
			[
				'base_uri' => $this->getRequestUrl(),
				'headers'  => [
					'Authorization' => sprintf('Bearer %s', $airtable->getApiKey())
				]
			]
		);
	}

    /**
     * Read a record.
     *
     * @param string $id
     *
     * @return Response
     */
    public function readRecord($id)
    {
        $response = $this->client->request('GET', $this->getRequestUrl() . '/' . $id);
        return new Response($response, $this);
    }

	/**
	 * Create new entry in record
	 *
	 * @param array $record
	 *
	 * @return Response
	 */
	public function createRecord(array $record)
	{
		$response = $this->client->request('POST', '', ['json' => ['fields' => $record]]);
		return new Response($response, $this);
	}

	/**
	 * Update existing record
	 *
	 * @param $id
	 * @param array $record
	 *
	 * @return Response
	 */
	public function updateRecord($id, array $record)
	{
		$response = $this->client->request('PATCH', $this->getRequestUrl() . '/' . $id, ['json' => ['fields' => $record]]);
		return new Response($response, $this);
	}

	/**
	 * Delete existring record
	 *
	 * @param $id
	 *
	 * @return Response
	 */
	public function deleteRecord($id)
	{
		$response = $this->client->request('DELETE', $this->getRequestUrl() . '/' . $id);
		return new Response($response, $this);
	}

	/**
	 * Get records from table
	 *
	 * @param array $parameters
	 *
	 * @return Response
	 */
	public function getTable($parameters = [])
	{
		$this->parameters = $parameters;

		$response = $this->client->request('GET', '?' . http_build_query($parameters));
		return new Response($response, $this);
	}

	/**
	 * @return string
	 */
	private function getRequestUrl(): string
	{
		return $this->airtable->getBaseUrl() . '/' . $this->airtable->getBase() . '/' . $this->table;
	}

	/**
	 * @return null|string
	 */
	public function getOffset()
	{
		return $this->offset;
	}

	/**
	 * @param null|string $offset
	 *
	 * @return $this
	 */
	public function setOffset($offset)
	{
		$this->offset = $offset;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}
}