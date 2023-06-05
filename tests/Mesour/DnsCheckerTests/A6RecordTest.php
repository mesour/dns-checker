<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\A6Record;

class A6RecordTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		self::assertFalse($records->isEmpty());
		self::assertCount(1, $records);
		self::assertInstanceOf(A6Record::class, $records[0]);
		self::assertSame($this->getExpectedRows(), $records->toArray());
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'A6',
				'name' => 'google.com',
				'content' => '64 2a00:1144:2567:800::200e SLAtest.v6.labs.example.com',
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
				'type' => 'A6',
				'masklen' => 64,
				'ipv6' => '2a00:1144:2567:800::200e',
				'chain' => 'SLAtest.v6.labs.example.com',
			],
		];
	}

}
