<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

class MxRecord extends DnsRecord
{

	private int|null $priority = null;

	private string $target;

	/**
	 * @param array<string>|array<int> $record
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

	public function getPriority(): int|null
	{
		return $this->priority;
	}

	public function getTarget(): string
	{
		return $this->target;
	}

}
