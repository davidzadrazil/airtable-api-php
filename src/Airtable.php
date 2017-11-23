<?php

namespace DavidZadrazil\AirtableApi;

/**
 * Class Airtable
 *
 * @package DavidZadrazil
 */
class Airtable
{
	const BASE_URL = 'https://api.airtable.com/v0';

	/**
	 * API key
	 *
	 * @var null|string
	 */
	private $apiKey = null;

	/**
	 * Base ID which is unique for each base
	 *
	 * @var null|string
	 */
	private $base = null;

	/**
	 * Airtable constructor.
	 *
	 * @param $apiKey
	 * @param $base
	 */
	public function __construct($apiKey, $base)
	{
		$this->apiKey = $apiKey;
		$this->base = $base;
	}

	/**
	 * @return null|string
	 */
	public function getApiKey(): string
	{
		return $this->apiKey;
	}

	/**
	 * @return null|string
	 */
	public function getBase(): string
	{
		return $this->base;
	}

	/**
	 * @return string
	 */
	public function getBaseUrl(): string
	{
		return self::BASE_URL;
	}
}