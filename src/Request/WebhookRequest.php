<?php

namespace DavidZadrazil\AirtableApi\Request;

use DavidZadrazil\AirtableApi\Request;
use DavidZadrazil\AirtableApi\Response\WebhookResponse as Response;

class WebhookRequest extends Request
{
    /**
     * Read all webhooks.
     *
     * @return Response
     */
    public function readWebhooks()
    {
        $response = $this->client->request('GET', $this->getRequestUrl());
        return new Response($response, $this);
    }

    /**
     * Create a new webhook.
     *
     * @param array $webhook
     *
     * @return Response
     */
    public function createWebhook(array $webhook)
    {
        $response = $this->client->request('POST', '', ['json' => $webhook]);
        return new Response($response, $this);
    }

    /**
     * Delete a webhook.
     *
     * @param string $id
     *
     * @return Response
     */
    public function deleteWebhook(string $id)
    {
        $response = $this->client->request('DELETE', $this->getRequestUrl() . '/' . $id);
        return new Response($response, $this);
    }

    /**
     * Refresh a webhook.
     *
     * @param string $id
     *
     * @return Response
     */
    public function refreshWebhook(string $id)
    {
        $response = $this->client->request('POST', $this->getRequestUrl() . '/' . $id . '/refresh');
        return new Response($response, $this);
    }

    protected function getRequestUrl(): string
    {
        return $this->airtable->getBaseUrl() . '/bases/' . $this->airtable->getBase() . '/webhooks';
    }
}
