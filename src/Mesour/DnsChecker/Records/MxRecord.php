<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker;

/**
 * @author Matouš Němec <mesour.com>
 */
class MxRecord extends DnsRecord
{

	/** @var int|null */
	private $priority;

	/** @var string */
	private $target;

	/**
	 * @param string[]|int[] $record
	 */
	public function __construct(array $record)
	{
		$this->priority = $record['pri']
			? (int) $record['pri']
			: null;
		$this->target = $record['target'];

		$content = $this->priority
			? ($this->priority . ' ' . $this->target)
			: $this->target;

		parent::__construct($record['type'], $record['host'], $content, $record['ttl']);
	}

	public function getPriority(): ?int
	{
		return $this->priority;
	}

	public function getTarget(): string
	{
		return $this->target;
	}

}
