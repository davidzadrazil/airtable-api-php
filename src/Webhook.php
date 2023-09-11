<?php

namespace DavidZadrazil\AirtableApi;

use DateTime;

class Webhook
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var \stdClass|null
     */
    protected $specification;

    /**
     * @var string|null
     */
    protected $notificationUrl;

    /**
     * @var DateTime
     */
    protected $expirationTime;

    public function __construct(\stdClass $data)
    {
        $this->setId($data->id);
        $this->setSpecification($data->specification ?? null);
        $this->setNotificationUrl($data->notificationUrl ?? null);
        $this->setExpirationTime(DateTime::createFromFormat('Y-m-d\TH:i:s.uZ', $data->expirationTime));
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Webhook
     */
    public function setId(string $id): Webhook
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \stdClass|null
     */
    public function getSpecification(): ?\stdClass
    {
        return $this->specification;
    }

    /**
     * @param \stdClass|null $specification
     * @return Webhook
     */
    public function setSpecification(?\stdClass $specification): Webhook
    {
        $this->specification = $specification;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotificationUrl(): ?string
    {
        return $this->notificationUrl;
    }

    /**
     * @param string|null $notificationUrl
     * @return Webhook
     */
    public function setNotificationUrl(?string $notificationUrl): Webhook
    {
        $this->notificationUrl = $notificationUrl;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getExpirationTime(): DateTime
    {
        return $this->expirationTime;
    }

    /**
     * @param DateTime $expirationTime
     * @return Webhook
     */
    public function setExpirationTime(DateTime $expirationTime): Webhook
    {
        $this->expirationTime = $expirationTime;
        return $this;
    }
}
