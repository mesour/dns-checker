<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

use const DNS_ANY;

class DnsRecordRequest
{

	/** @var array<array<int|string>> */
	private array $domainPairs = [];

	public function addFilter(string $domain, int $type = DNS_ANY): void
	{
		$this->domainPairs[] = [$domain, $type];
	}

	/**
	 * @return array<array<int|string>>
	 */
	public function getDomainPairs(): array
	{
		return $this->domainPairs;
	}

}
