<?php declare(strict_types = 1);

namespace Mesour\DnsChecker\Providers;

use const DNS_ANY;

interface IDnsRecordProvider
{

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	public function getDnsRecordArray(string $domain, int $type = DNS_ANY): array;

}
