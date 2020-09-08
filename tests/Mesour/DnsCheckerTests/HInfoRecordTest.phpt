<?php

declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\HInfoRecord;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class HInfoRecordTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		Assert::false($records->isEmpty());
		Assert::count(1, $records);
		Assert::type(HInfoRecord::class, $records[0]);
		Assert::same($this->getExpectedRows(), $records->toArray());
	}

	/**
	 * @return string[]|int[]
	 */
	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'HINFO',
				'name' => 'google.com',
				'content' => 'CPU-type linux-os',
				'ttl' => 86400,
			],
		];
	}

	/**
	 * @return string[]|int[]
	 */
	private function getDnsRows(): array
	{
		return [
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 86400,
				'type' => 'HINFO',
				'cpu' => 'CPU-type',
				'os' => 'linux-os',
			],
		];
	}

}

$test = new HInfoRecordTest();
$test->run();
