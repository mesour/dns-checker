<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker;

/**
 * @author Matouš Němec <mesour.com>
 */
class CaaRecord extends DnsRecord
{

	/** @var int */
	private $flags;

	/** @var string */
	private $tag;

	/** @var string */
	private $value;

	/**
	 * @param string[]|int[] $record
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
