<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsProvider\MxRecord;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class MxRecordTest extends BaseTestCase
{

	public function testDefault()
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		Assert::false($records->isEmpty());
		Assert::count(3, $records);
		Assert::type(MxRecord::class, $records[0]);
		Assert::same($this->getExpectedRows(), $records->toArray());
	}

	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'MX',
				'name' => 'example.com',
				'content' => '40 alt3.aspmx.l.example.com',
				'ttl' => 404,
			],
			[
				'type' => 'MX',
				'name' => 'example.com',
				'content' => '50 alt4.aspmx.l.example.com',
				'ttl' => 404,
			],
			[
				'type' => 'MX',
				'name' => 'example.com',
				'content' => '30 alt2.aspmx.l.example.com',
				'ttl' => 404,
			],
		];
	}

	private function getDnsRows(): array
	{
		return [
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 40,
				'target' => 'alt3.aspmx.l.example.com',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 50,
				'target' => 'alt4.aspmx.l.example.com',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 30,
				'target' => 'alt2.aspmx.l.example.com',
			],
		];
	}

}

$test = new MxRecordTest();
$test->run();
