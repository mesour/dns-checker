<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\Diffs\DnsRecordDiff;
use Mesour\DnsChecker\Diffs\DnsRecordSetDiffFactory;
use Mesour\DnsChecker\DnsRecord;
use Mesour\DnsChecker\DnsRecordSet;

class DnsRecordSetDiffTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$factory = new DnsRecordSetDiffFactory();

		$expected = $this->createExpectedDnsRecordSet();

		$checker = $this->createChecker($this->getDnsRecords());
		$recordSet = $checker->getDnsRecordSet('example.com');

		$diff = $factory->createDiff($expected, $recordSet);

		self::assertTrue($diff->hasDifferentRecord());

		$diffs = $diff->getDiffs();

		self::assertCount(5, $diffs);
		self::assertInstanceOf(DnsRecordDiff::class, $diffs[0]);

		$notDifferent = $diffs[0];
		self::assertInstanceOf(DnsRecordDiff::class, $notDifferent);
		self::assertFalse($notDifferent->isDifferent());
		self::assertSame($this->getExpectedARecord(), $notDifferent->getExpectedRecord()->toArray());

		$different = $diffs[4];
		self::assertInstanceOf(DnsRecordDiff::class, $different);
		self::assertTrue($different->isDifferent());
		self::assertSame($this->getExpectedAAAARecord(), $different->getExpectedRecord()->toArray());
		self::assertCount(0, $different->getSimilarRecords());

		$differentMx = $diffs[3];
		self::assertInstanceOf(DnsRecordDiff::class, $differentMx);
		self::assertTrue($differentMx->isDifferent());
		self::assertSame($this->getExpectedMxRecord(), $differentMx->getExpectedRecord()->toArray());
		self::assertCount(2, $differentMx->getSimilarRecords());

		$similarRecord = $differentMx->getSimilarRecords()[1];
		self::assertInstanceOf(DnsRecord::class, $similarRecord);
		self::assertInstanceOf(DnsRecord::class, $similarRecord);
		self::assertSame($this->getSimilarMxRecord(), $similarRecord->toArray());
	}

	/**
	 * @return array<string>|array<int>
	 */
	private function getExpectedARecord(): array
	{
		return [
			'type' => 'A',
			'name' => 'example.com',
			'content' => '216.58.201.78',
			'ttl' => 34,
		];
	}

	/**
	 * @return array<string>|array<int>
	 */
	private function getExpectedAAAARecord(): array
	{
		return [
			'type' => 'AAAA',
			'name' => 'example.com',
			'content' => '2a00:5565:4444:800::200e',
			'ttl' => 300,
		];
	}

	/**
	 * @return array<string>|array<int>
	 */
	private function getExpectedMxRecord(): array
	{
		return [
			'type' => 'MX',
			'name' => 'example.com',
			'content' => '10 aspmx.example.com',
			'ttl' => 404,
		];
	}

	/**
	 * @return array<string>|array<int>
	 */
	private function getSimilarMxRecord(): array
	{
		return [
			'type' => 'MX',
			'name' => 'example.com',
			'content' => '10 aspmx.l.example.com',
			'ttl' => 404,
		];
	}

	private function createExpectedDnsRecordSet(): DnsRecordSet
	{
		$out = [];

		foreach ($this->getExpectedDnsRecords() as $record) {
			$item = DnsRecord::fromPhpArray($record);
			self::assertInstanceOf(DnsRecord::class, $item);
			$out[] = $item;
		}

		return new DnsRecordSet($out);
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getExpectedDnsRecords(): array
	{
		return [
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 34,
				'type' => 'A',
				'ip' => '216.58.201.78',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 52_107,
				'type' => 'NS',
				'target' => 'ns3.example.com',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 30,
				'target' => 'alt2.aspmx.l.example.com',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 10,
				'target' => 'aspmx.example.com',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 300,
				'type' => 'AAAA',
				'ipv6' => '2a00:5565:4444:800::200e',
			],
		];
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getDnsRecords(): array
	{
		return [
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 34,
				'type' => 'A',
				'ip' => '216.58.201.78',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 52_107,
				'type' => 'NS',
				'target' => 'ns3.example.com',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 30,
				'target' => 'alt2.aspmx.l.example.com',
			],
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 10,
				'target' => 'aspmx.l.example.com',
			],
		];
	}

}
