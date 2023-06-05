<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\DnsRecord;

class PtrRecordTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		self::assertFalse($records->isEmpty());
		self::assertCount(1, $records);
		self::assertInstanceOf(DnsRecord::class, $records[0]);
		self::assertSame($this->getExpectedRows(), $records->toArray());
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'PTR',
				'name' => 'example.com',
				'content' => 'test.example.com',
				'ttl' => 300,
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
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 300,
				'type' => 'PTR',
				'target' => 'test.example.com',
			],
		];
	}

}
