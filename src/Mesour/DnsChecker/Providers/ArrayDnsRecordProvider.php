<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker\Providers;

/**
 * @author Matouš Němec <mesour.com>
 */
class ArrayDnsRecordProvider implements IDnsRecordProvider
{

	/** @var string[][]|int[][] */
	private $dnsArrayList;

	/**
	 * @param string[][]|int[][] $dnsArrayList
	 */
	public function __construct(array $dnsArrayList)
	{
		$this->dnsArrayList = $dnsArrayList;
	}

	/**
	 * @param string $domain
	 * @param int $type
	 * @return string[][]|int[][]
	 */
	public function getDnsRecordArray(string $domain, int $type = \DNS_ANY): array
	{
		if (!isset($this->dnsArrayList[0])) {
			throw new \InvalidArgumentException('No remaining stored dns array to match.');
		}

		return \array_shift($this->dnsArrayList);
	}

}
