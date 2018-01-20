<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsProvider\DnsRecord;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class NsRecordTest extends BaseTestCase
{

	public function testDefault()
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		Assert::false($records->isEmpty());
		Assert::count(1, $records);
		Assert::type(DnsRecord::class, $records[0]);
		Assert::same($this->getExpectedRows(), $records->toArray());
	}

	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'NS',
				'name' => 'example.com',
				'content' => 'test.example.com',
				'ttl' => 900,
			],
		];
	}

	private function getDnsRows(): array
	{
		return [
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 900,
				'type' => 'NS',
				'target' => 'test.example.com',
			],
		];
	}

}

$test = new NsRecordTest();
$test->run();
