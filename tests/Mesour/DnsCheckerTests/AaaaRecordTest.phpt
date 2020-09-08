<?php

declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\AaaaDnsRecord;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class AaaaRecordTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		Assert::false($records->isEmpty());
		Assert::count(1, $records);
		Assert::type(AaaaDnsRecord::class, $records[0]);
		Assert::same($this->getExpectedRows(), $records->toArray());
	}

	/**
	 * @return string[]|int[]
	 */
	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'AAAA',
				'name' => 'example.com',
				'content' => '2a00:1450:4014:800::200e',
				'ttl' => 300,
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
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 300,
				'type' => 'AAAA',
				'ipv6' => '2a00:1450:4014:800::200e',
			],
		];
	}

}

$test = new AaaaRecordTest();
$test->run();
