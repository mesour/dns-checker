<?php

declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\DnsRecord;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class CNameRecordTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		Assert::false($records->isEmpty());
		Assert::count(1, $records);
		Assert::type(DnsRecord::class, $records[0]);
		Assert::same($this->getExpectedRows(), $records->toArray());
	}

	/**
	 * @return string[]|int[]
	 */
	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'CNAME',
				'name' => 'example.com',
				'content' => '*.example.com',
				'ttl' => 1800,
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
				'ttl' => 1800,
				'type' => 'CNAME',
				'target' => '*.example.com',
			],
		];
	}

}

$test = new CNameRecordTest();
$test->run();
