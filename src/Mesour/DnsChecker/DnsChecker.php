<?php

namespace Mesour\DnsChecker;

use Mesour\DnsChecker\Providers\IDnsRecordProvider;

/**
 * @author Matouš Němec <mesour.com>
 */
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

	/**
	 * @param DnsRecordRequest $request
	 * @return DnsRecordSet
	 */
	public function getDnsRecordSetFromRequest(DnsRecordRequest $request): DnsRecordSet
	{
		/** @var DnsRecordSet|null $output */
		$output = null;
		foreach ($request->getDomainPairs() as list ($domain, $type)) {
			$records = $this->dnsRecordProvider->getDnsRecordArray($domain, $type);
			$out = [];

			foreach ($records as $record) {
				$out[] = DnsRecord::fromPhpArray($record);
			}
			$dnsRecordSet = new DnsRecordSet($out);
			if ($output === null) {
				$output = $dnsRecordSet;
			} else {
				$output = $output->merge($dnsRecordSet);
			}
		}
		return $output === null ? new DnsRecordSet([]) : $output;
	}

}
