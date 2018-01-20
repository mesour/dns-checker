<?php

namespace Mesour\DnsProvider;

class A6Record extends DnsRecord
{

	/**
	 * @var int
	 */
	private $masklen;

	/**
	 * @var string
	 */
	private $ipV6;

	/**
	 * @var mixed
	 */
	private $chain;

	/**
	 * @param array $record
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

	public function getChain()
	{
		return $this->chain;
	}

}
