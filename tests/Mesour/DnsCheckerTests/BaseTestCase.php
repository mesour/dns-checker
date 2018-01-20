<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsProvider\DnsChecker;
use Mesour\DnsProvider\Providers\StaticDnsRecordProvider;
use Tester\TestCase;

class BaseTestCase extends TestCase
{

	protected function createChecker(array $dnsRows)
	{
		$provider = new StaticDnsRecordProvider($dnsRows);
		return new DnsChecker($provider);
	}

}
