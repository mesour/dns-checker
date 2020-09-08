<?php

declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\DnsRecord;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class TxtRecordTest extends BaseTestCase
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
				'type' => 'TXT',
				'name' => 'example.com',
				'content' => 'v=spf1 include:_spf.example.com ~all',
				'ttl' => 1542,
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
				'ttl' => 1542,
				'type' => 'TXT',
				'txt' => 'v=spf1 include:_spf.example.com ~all',
				'entries' => ['v=spf1 include:_spf.example.com ~all'],
			],
		];
	}

}

$test = new TxtRecordTest();
$test->run();
