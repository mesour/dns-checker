<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\SrvRecord;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class SrvRecordTest extends BaseTestCase
{

	public function testDefault()
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		Assert::false($records->isEmpty());
		Assert::count(1, $records);
		Assert::type(SrvRecord::class, $records[0]);
		Assert::same($this->getExpectedRows(), $records->toArray());
	}

	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'SRV',
				'name' => 'google.com',
				'content' => '5 0 5060 sipserver.example.com',
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
				'type' => 'SRV',
				'pri' => 5,
				'weight' => 0,
				'port' => 5060,
				'target' => 'sipserver.example.com',
			],
		];
	}

}

$test = new SrvRecordTest();
$test->run();
