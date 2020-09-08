<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker;

/**
 * @author Matouš Němec <mesour.com>
 */
class DnsRecordRequest
{

	/** @var string[]|int[] */
	private $domainPairs = [];

	public function addFilter(string $domain, int $type = \DNS_ANY): void
	{
		$this->domainPairs[] = [$domain, $type];
	}

	/**
	 * @return string[]|int[]
	 */
	public function getDomainPairs(): array
	{
		return $this->domainPairs;
	}

}
