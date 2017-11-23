<?php

namespace DavidZadrazil\AirtableApi;

use DateTime;

/**
 * Class Record
 *
 * @package DavidZadrazil
 */
class Record
{
	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var DateTime
	 */
	protected $createdTime;

	/**
	 * @var \stdClass
	 */
	protected $fields;

	/**
	 * Record constructor.
	 *
	 * @param \stdClass $data
	 */
	public function __construct(\stdClass $data)
	{
		$this->setId($data->id);
		$this->setFields($data->fields);
		$this->setCreatedTime(DateTime::createFromFormat('Y-m-d\TH:i:s.uZ', $data->createdTime));
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
	 *
	 * @return $this
	 */
	public function setId(string $id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getCreatedTime(): DateTime
	{
		return $this->createdTime;
	}

	/**
	 * @param DateTime $createdTime
	 *
	 * @return $this
	 */
	public function setCreatedTime(DateTime $createdTime)
	{
		$this->createdTime = $createdTime;
		return $this;
	}

	/**
	 * @return \stdClass
	 */
	public function getFields(): \stdClass
	{
		return $this->fields;
	}

	/**
	 * @param \stdClass $fields
	 *
	 * @return $this
	 */
	public function setFields(\stdClass $fields)
	{
		$this->fields = $fields;
		return $this;
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function __get($name)
	{
		if (isset($this->getFields()->{$name})) {
			return $this->getFields()->{$name};
		} else {
			return null; // TODO: throw error
		}
	}
}