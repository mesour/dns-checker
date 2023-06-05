<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\DnsRecord;

class TxtRecordTest extends BaseTestCase
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
				'type' => 'TXT',
				'name' => 'example.com',
				'content' => 'v=spf1 include:_spf.example.com ~all',
				'ttl' => 1_542,
			],
		];
	}

	/**
	 * @return array<array<array<string>|int|string>>
	 */
	private function getDnsRows(): array
	{
		return [
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 1_542,
				'type' => 'TXT',
				'txt' => 'v=spf1 include:_spf.example.com ~all',
				'entries' => ['v=spf1 include:_spf.example.com ~all'],
			],
		];
	}

}
