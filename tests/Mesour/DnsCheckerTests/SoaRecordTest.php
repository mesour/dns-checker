<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\SoaRecord;

class SoaRecordTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		self::assertFalse($records->isEmpty());
		self::assertCount(1, $records);
		self::assertInstanceOf(SoaRecord::class, $records[0]);
		self::assertSame($this->getExpectedRows(), $records->toArray());
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
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

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
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
				'serial' => 182_582_804,
				'refresh' => 900,
				'retry' => 900,
				'expire' => 1_800,
				'minimum-ttl' => 60,
			],
		];
	}

}
