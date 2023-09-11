<?php

namespace DavidZadrazil\AirtableApi;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

abstract class Response
{
    /**
     * @var GuzzleResponse
     */
    private $response;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var bool
     */
    private $success;

    /**
     * Response constructor.
     *
     * @param GuzzleResponse $response
     * @param Request $request
     */
    public function __construct(GuzzleResponse $response, Request $request)
    {
        $this->request = $request;
        $this->response = $response;
        $this->success = $response->getStatusCode() === 200 ? true : false;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }
}
