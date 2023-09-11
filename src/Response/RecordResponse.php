<?php

namespace DavidZadrazil\AirtableApi\Response;

use DavidZadrazil\AirtableApi\Record;
use DavidZadrazil\AirtableApi\Request;
use DavidZadrazil\AirtableApi\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class RecordResponse extends Response
{
    /**
     * @var array
     */
    private $records = [];

    /**
     * @var null
     */
    public $offset = null;

    /**
     * Response constructor.
     *
     * @param GuzzleResponse $response
     * @param Request $request
     */
    public function __construct(GuzzleResponse $response, Request $request)
    {
        parent::__construct($response, $request);

        $content = json_decode($response->getBody()->getContents());
        if ($this->isSuccess() && json_last_error() === 0 && !empty($content) && !isset($content->deleted)) {
            if (isset($content->records)) {
                foreach ($content->records as $record) {
                    $this->records[] = new Record($record);
                }
            } else if (isset($content->id)) {
                $this->records[] = new Record($content);
            }

            if (isset($content->offset)) {
                $this->offset = $content->offset;
            } else {
                $this->offset = null;
            }
        } else {
            $this->offset = null;
        }
    }

    /**
     * @return array
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    /**
     * @return bool|Response
     */
    public function nextPage()
    {
        if (is_null($this->offset)) {
            return false;
        }

        if (empty($this->records)) {
            return false;
        }

        return $this->request->getTable(array_merge($this->request->getParameters(), ['offset' => $this->offset]));
    }
}
