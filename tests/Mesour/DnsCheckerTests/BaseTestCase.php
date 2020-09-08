<?php

declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\DnsChecker;
use Mesour\DnsChecker\Providers\StaticDnsRecordProvider;
use Tester\Environment;
use Tester\TestCase;

abstract class BaseTestCase extends TestCase
{

	protected function setUp(): void
	{
		parent::setUp();

		Environment::lock('test', __DIR__ . '/../../tmp');
	}

	/**
	 * @param string[][]|int[][] $dnsRows
	 * @return DnsChecker
	 */
	protected function createChecker(array $dnsRows): DnsChecker
	{
		$provider = new StaticDnsRecordProvider($dnsRows);

		return new DnsChecker($provider);
	}

}
