<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker\Providers;

/**
 * @author Matouš Němec <mesour.com>
 */
interface IDnsRecordProvider
{

	/**
	 * @param string $domain
	 * @param int $type
	 * @return string[][]|int[][]
	 */
	public function getDnsRecordArray(string $domain, int $type = \DNS_ANY): array;

}
