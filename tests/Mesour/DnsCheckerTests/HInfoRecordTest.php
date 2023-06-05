<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\HInfoRecord;

class HInfoRecordTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		self::assertFalse($records->isEmpty());
		self::assertCount(1, $records);
		self::assertInstanceOf(HInfoRecord::class, $records[0]);
		self::assertSame($this->getExpectedRows(), $records->toArray());
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'HINFO',
				'name' => 'google.com',
				'content' => 'CPU-type linux-os',
				'ttl' => 86_400,
			],
		];
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getDnsRows(): array
	{
		return [
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 86_400,
				'type' => 'HINFO',
				'cpu' => 'CPU-type',
				'os' => 'linux-os',
			],
		];
	}

}
