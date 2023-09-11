<?php

namespace DavidZadrazil\AirtableApi\Request;

use DavidZadrazil\AirtableApi\Airtable;
use DavidZadrazil\AirtableApi\Request;
use DavidZadrazil\AirtableApi\Response\RecordResponse as Response;

class RecordRequest extends Request
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var null|string
     */
    protected $offset = null;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Request constructor.
     *
     * @param Airtable $airtable
     * @param string $table
     */
    public function __construct(Airtable $airtable, string $table)
    {
        parent::__construct($airtable);
        $this->table = $table;
    }

    /**
     * Read a record.
     *
     * @param string $id
     *
     * @return Response
     */
    public function readRecord(string $id)
    {
        $response = $this->client->request('GET', $this->getRequestUrl() . '/' . $id);
        return new Response($response, $this);
    }

    /**
     * Create a new record.
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
     * Update an existing record.
     *
     * @param string $id
     * @param array $record
     *
     * @return Response
     */
    public function updateRecord(string $id, array $record)
    {
        $response = $this->client->request('PATCH', $this->getRequestUrl() . '/' . $id, ['json' => ['fields' => $record]]);
        return new Response($response, $this);
    }

    /**
     * Delete an existing record.
     *
     * @param string $id
     *
     * @return Response
     */
    public function deleteRecord(string $id)
    {
        $response = $this->client->request('DELETE', $this->getRequestUrl() . '/' . $this->table . '/' . $id);
        return new Response($response, $this);
    }

    /**
     * Get records from a table.
     *
     * @param array $parameters
     *
     * @return Response
     */
    public function getTable(array $parameters = [])
    {
        $this->parameters = $parameters;

        $response = $this->client->request('GET', '?' . http_build_query($parameters));
        return new Response($response, $this);
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

    protected function getRequestUrl(): string
    {
        return $this->airtable->getBaseUrl() . '/' . $this->airtable->getBase() . '/' . $this->table;
    }
}
