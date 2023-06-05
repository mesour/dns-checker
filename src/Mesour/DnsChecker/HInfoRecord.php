<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

class HInfoRecord extends DnsRecord
{

	private string $cpu;

	private string $os;

	/**
	 * @param array<string>|array<int> $record
	 */
	public function __construct(array $record)
	{
		$this->cpu = $record['cpu'];
		$this->os = $record['os'];

		$content = $this->cpu . ' ' . $this->os;

		parent::__construct($record['type'], $record['host'], $content, $record['ttl']);
	}

	public function getCpu(): string
	{
		return $this->cpu;
	}

	public function getOs(): string
	{
		return $this->os;
	}

}
