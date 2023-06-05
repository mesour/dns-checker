<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

class A6Record extends DnsRecord
{

	private int $masklen;

	private string $ipV6;

	private int|string $chain;

	/**
	 * @param array<string>|array<int> $record
	 */
	public function __construct(array $record)
	{
		$this->masklen = $record['masklen'];
		$this->ipV6 = $record['ipv6'];
		$this->chain = $record['chain'];

		$content = $this->masklen . ' ' . $this->ipV6 . ' ' . $this->chain;

		parent::__construct($record['type'], $record['host'], $content, $record['ttl']);
	}

	public function getMasklen(): int
	{
		return $this->masklen;
	}

	public function getIpV6(): string
	{
		return $this->ipV6;
	}

	public function getChain(): int|string
	{
		return $this->chain;
	}

}
