<?php

namespace Mesour\DnsChecker;

/**
 * @author Matouš Němec <mesour.com>
 */
class DnsRecordRequest
{

	/**
	 * @var array[]
	 */
	private $domainPairs = [];

	/**
	 * @param string $domain
	 * @param int $type
	 * @return void
	 */
	public function addFilter(string $domain, int $type = DNS_ANY)
	{
		$this->domainPairs[] = [$domain, $type];
	}

	/**
	 * @return array[]
	 */
	public function getDomainPairs(): array
	{
		return $this->domainPairs;
	}

}
