<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\MxRecord;

class MxRecordTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		self::assertFalse($records->isEmpty());
		self::assertCount(3, $records);
		self::assertInstanceOf(MxRecord::class, $records[0]);
		self::assertSame($this->getExpectedRows(), $records->toArray());
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'MX',
				'name' => 'example.com',
				'content' => '40 alt3.aspmx.l.example.com',
				'ttl' => 404,
			],
			[
				'type' => 'MX',
				'name' => 'example.com',
				'content' => '50 alt4.aspmx.l.example.com',
				'ttl' => 404,
			],
			[
				'type' => 'MX',
				'name' => 'example.com',
				'content' => '30 alt2.aspmx.l.example.com',
				'ttl' => 404,
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
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 40,
				'target' => 'alt3.aspmx.l.example.com',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 50,
				'target' => 'alt4.aspmx.l.example.com',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 30,
				'target' => 'alt2.aspmx.l.example.com',
			],
		];
	}

}
