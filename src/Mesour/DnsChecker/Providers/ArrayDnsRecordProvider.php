<?php

namespace Mesour\DnsChecker\Providers;

class ArrayDnsRecordProvider implements IDnsRecordProvider
{

	/**
	 * @var array[]
	 */
	private $dnsArrayList;

	public function __construct(array $dnsArrayList)
	{
		$this->dnsArrayList = $dnsArrayList;
	}

	/**
	 * @param string $domain
	 * @param int $type
	 * @return array[]
	 */
	public function getDnsRecordArray($domain, int $type = DNS_ANY): array
	{
		if (!isset($this->dnsArrayList[0])) {
			throw new \InvalidArgumentException('No remaining stored dns array to match.');
		}

		return array_shift($this->dnsArrayList);
	}

}
