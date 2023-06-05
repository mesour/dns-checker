<?php declare(strict_types = 1);

namespace Mesour\DnsChecker\Providers;

use const DNS_ANY;

class StaticDnsRecordProvider implements IDnsRecordProvider
{

	/**
	 * @param array<array<array<string>|int|string>> $dnsArray
	 */
	public function __construct(private array $dnsArray)
	{
	}

	/**
	 * @return array<array<array<string>|int|string>>
	 */
	public function getDnsRecordArray(string $domain, int $type = DNS_ANY): array
	{
		return $this->dnsArray;
	}

}
