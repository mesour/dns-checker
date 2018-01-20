<?php

namespace Mesour\DnsChecker\Providers;

/**
 * @author Matouš Němec <mesour.com>
 */
class StaticDnsRecordProvider implements IDnsRecordProvider
{

	/**
	 * @var array
	 */
	private $dnsArray;

	public function __construct(array $dnsArray)
	{
		$this->dnsArray = $dnsArray;
	}

	/**
	 * @param string $domain
	 * @param int $type
	 * @return array[]
	 */
	public function getDnsRecordArray($domain, int $type = DNS_ANY): array
	{
		return $this->dnsArray;
	}

}
