<?php

namespace Mesour\DnsProvider;

class MxRecord extends DnsRecord
{

	/**
	 * @var int|null
	 */
	private $priority;

	/**
	 * @var string
	 */
	private $target;

	/**
	 * @param array $record
	 */
	public function __construct(array $record)
	{
		$this->priority = isset($record['pri']) ? $record['pri'] : null;
		$this->target = $record['target'];

		$content = $this->priority ? ($this->priority . ' ' . $this->target) : $this->target;
		parent::__construct($record['type'], $record['host'], $content, $record['ttl']);

	}

	/**
	 * @return int|null
	 */
	public function getPriority()
	{
		return $this->priority;
	}

	public function getTarget(): string
	{
		return $this->target;
	}

}
