<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

class CaaRecord extends DnsRecord
{

	private int $flags;

	private string $tag;

	private string $value;

	/**
	 * @param array<string>|array<int> $record
	 */
	public function __construct(array $record)
	{
		$this->flags = $record['flags'];
		$this->tag = $record['tag'];
		$this->value = $record['value'];

		$content = $this->flags . ' ' . $this->tag . ' ' . $this->value;

		parent::__construct($record['type'], $record['host'], $content, $record['ttl']);
	}

	public function getFlags(): int
	{
		return $this->flags;
	}

	public function getTag(): string
	{
		return $this->tag;
	}

	public function getValue(): string
	{
		return $this->value;
	}

}
