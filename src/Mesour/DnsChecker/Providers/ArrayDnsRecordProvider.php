<?php declare(strict_types = 1);

namespace Mesour\DnsChecker\Providers;

use InvalidArgumentException;
use function array_shift;
use const DNS_ANY;

class ArrayDnsRecordProvider implements IDnsRecordProvider
{

	/**
	 * @param array<array<array<string>>>|array<array<array<int>>> $dnsArrayList
	 */
	public function __construct(private array $dnsArrayList)
	{
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	public function getDnsRecordArray(string $domain, int $type = DNS_ANY): array
	{
		if (!isset($this->dnsArrayList[0])) {
			throw new InvalidArgumentException('No remaining stored dns array to match.');
		}

		return array_shift($this->dnsArrayList);
	}

}
