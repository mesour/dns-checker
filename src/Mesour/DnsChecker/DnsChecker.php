<?php

namespace Mesour\DnsProvider;

use Mesour\DnsProvider\Providers\IDnsRecordProvider;

class DnsChecker
{

	/**
	 * @var IDnsRecordProvider
	 */
	private $dnsRecordProvider;

	public function __construct(IDnsRecordProvider $dnsRecordProvider)
	{
		$this->dnsRecordProvider = $dnsRecordProvider;
	}

	/**
	 * @param string $domain
	 * @param int $type
	 * @return DnsRecordSet
	 */
	public function getDnsRecordSet(string $domain, int $type = DNS_ANY): DnsRecordSet
	{
		$records = $this->dnsRecordProvider->getDnsRecordArray($domain, $type);
		$out = [];

		foreach ($records as $record) {
			$out[] = DnsRecord::fromPhpArray($record);
		}
		return new DnsRecordSet($out);
	}

}
