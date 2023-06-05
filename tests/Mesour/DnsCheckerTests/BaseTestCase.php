<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\DnsChecker;
use Mesour\DnsChecker\Providers\StaticDnsRecordProvider;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{

	/**
	 * @param array<array<array<string>|int|string>> $dnsRows
	 */
	protected function createChecker(array $dnsRows): DnsChecker
	{
		$provider = new StaticDnsRecordProvider($dnsRows);
		return new DnsChecker($provider);
	}

}
