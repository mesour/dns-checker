<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\DnsChecker;
use Mesour\DnsChecker\Providers\StaticDnsRecordProvider;
use Tester\TestCase;

class BaseTestCase extends TestCase
{

	protected function createChecker(array $dnsRows)
	{
		$provider = new StaticDnsRecordProvider($dnsRows);
		return new DnsChecker($provider);
	}

}
