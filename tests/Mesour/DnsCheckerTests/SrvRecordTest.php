<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\SrvRecord;

class SrvRecordTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		self::assertFalse($records->isEmpty());
		self::assertCount(1, $records);
		self::assertInstanceOf(SrvRecord::class, $records[0]);
		self::assertSame($this->getExpectedRows(), $records->toArray());
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'SRV',
				'name' => 'google.com',
				'content' => '5 0 5060 sipserver.example.com',
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
				'type' => 'SRV',
				'pri' => 5,
				'weight' => 0,
				'port' => 5_060,
				'target' => 'sipserver.example.com',
			],
		];
	}

}
