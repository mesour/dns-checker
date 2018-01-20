<?php

namespace Mesour\DnsChecker\Providers;

/**
 * @author Matouš Němec <mesour.com>
 */
interface IDnsRecordProvider
{

	/**
	 * @param string $domain
	 * @param int $type
	 * @return array[]
	 */
	public function getDnsRecordArray($domain, int $type = DNS_ANY): array;

}
