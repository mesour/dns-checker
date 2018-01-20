<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsProvider\A6Record;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class A6RecordTest extends BaseTestCase
{

	public function testDefault()
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		Assert::false($records->isEmpty());
		Assert::count(1, $records);
		Assert::type(A6Record::class, $records[0]);
		Assert::same($this->getExpectedRows(), $records->toArray());
	}

	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'A6',
				'name' => 'google.com',
				'content' => '64 2a00:1144:2567:800::200e SLAtest.v6.labs.example.com',
				'ttl' => 86400,
			],
		];
	}

	private function getDnsRows(): array
	{
		return [
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 86400,
				'type' => 'A6',
				'masklen' => 64,
				'ipv6' => '2a00:1144:2567:800::200e',
				'chain' => 'SLAtest.v6.labs.example.com',
			],
		];
	}

}

$test = new A6RecordTest();
$test->run();
