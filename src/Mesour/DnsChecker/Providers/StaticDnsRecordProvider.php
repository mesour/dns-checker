<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker\Providers;

/**
 * @author Matouš Němec <mesour.com>
 */
class StaticDnsRecordProvider implements IDnsRecordProvider
{

	/** @var string[][]|int[][] */
	private $dnsArray;

	/**
	 * @param string[][]|int[][] $dnsArray
	 */
	public function __construct(array $dnsArray)
	{
		$this->dnsArray = $dnsArray;
	}

	/**
	 * @param string $domain
	 * @param int $type
	 * @return string[][]|int[][]
	 */
	public function getDnsRecordArray(string $domain, int $type = \DNS_ANY): array
	{
		return $this->dnsArray;
	}

}
