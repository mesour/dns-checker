<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsProvider\SoaRecord;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class SoaRecordTest extends BaseTestCase
{

	public function testDefault()
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		Assert::false($records->isEmpty());
		Assert::count(1, $records);
		Assert::type(SoaRecord::class, $records[0]);
		Assert::same($this->getExpectedRows(), $records->toArray());
	}

	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'SOA',
				'name' => 'google.com',
				'content' => 'ns1.google.com dns-admin.google.com 182582804 900 900 1800 60',
				'ttl' => 60,
			],
		];
	}

	private function getDnsRows(): array
	{
		return [
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 60,
				'type' => 'SOA',
				'mname' => 'ns1.google.com',
				'rname' => 'dns-admin.google.com',
				'serial' => 182582804,
				'refresh' => 900,
				'retry' => 900,
				'expire' => 1800,
				'minimum-ttl' => 60,
			],
		];
	}

}

$test = new SoaRecordTest();
$test->run();
