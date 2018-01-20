<?php

namespace Mesour\DnsProvider\Providers;

interface IDnsRecordProvider
{

	/**
	 * @param string $domain
	 * @param int $type
	 * @return array[]
	 */
	public function getDnsRecordArray($domain, int $type = DNS_ANY): array;

}
