<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker;

use Mesour\DnsChecker\Providers\IDnsRecordProvider;

/**
 * @author Matouš Němec <mesour.com>
 */
class DnsChecker
{

	/** @var IDnsRecordProvider */
	private $dnsRecordProvider;

	public function __construct(IDnsRecordProvider $dnsRecordProvider)
	{
		$this->dnsRecordProvider = $dnsRecordProvider;
	}

	public function getDnsRecordSet(string $domain, int $type = \DNS_ANY): DnsRecordSet
	{
		$records = $this->dnsRecordProvider->getDnsRecordArray($domain, $type);
		$out = [];

		foreach ($records as $record) {
			$out[] = DnsRecord::fromPhpArray($record);
		}

		return new DnsRecordSet($out);
	}

	public function getDnsRecordSetFromRequest(DnsRecordRequest $request): DnsRecordSet
	{
		$output = null;
		\assert($output instanceof DnsRecordSet || $output === null);

		foreach ($request->getDomainPairs() as [$domain, $type]) {
			$records = $this->dnsRecordProvider->getDnsRecordArray($domain, $type);
			$out = [];

			foreach ($records as $record) {
				$out[] = DnsRecord::fromPhpArray($record);
			}

			$dnsRecordSet = new DnsRecordSet($out);

			$output = $output === null
				? $dnsRecordSet
				: $output->merge($dnsRecordSet);
		}

		return $output ?? new DnsRecordSet([]);
	}

}
