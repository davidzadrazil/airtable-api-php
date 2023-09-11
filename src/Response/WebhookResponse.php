<?php

namespace DavidZadrazil\AirtableApi\Response;

use DavidZadrazil\AirtableApi\Record;
use DavidZadrazil\AirtableApi\Request;
use DavidZadrazil\AirtableApi\Response;
use DavidZadrazil\AirtableApi\Webhook;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class WebhookResponse extends Response
{
    /**
     * @var array
     */
    private $webhooks = [];

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
            if (isset($content->webhooks)) {
                foreach ($content->webhooks as $webhook) {
                    $this->webhooks[] = new Webhook($webhook);
                }
            } else if (isset($content->id)) {
                $this->webhooks[] = new Webhook($content);
            }
        }
    }

    /**
     * @return array
     */
    public function getWebhooks(): array
    {
        return $this->webhooks;
    }
}
