<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\AaaaDnsRecord;
use Mesour\DnsChecker\DnsRecord;
use Mesour\DnsChecker\DnsRecordType;
use Mesour\DnsChecker\MxRecord;

class DnsRecordSetTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$checker = $this->createChecker($this->getDnsRecords());
		$records = $checker->getDnsRecordSet('example.com');

		self::assertFalse($records->isEmpty());
		self::assertCount(6, $records);

		$nsDnsRecord = new DnsRecord('NS', 'example.com', 'ns3.google.com');
		self::assertTrue($records->hasRecord($nsDnsRecord));

		$dnsRecord = new AaaaDnsRecord('AAAA', 'example.com', '2a00:1450:4014:800::200e');
		self::assertTrue($records->hasRecord($dnsRecord));

		$record = $records->getMatchingRecord($dnsRecord);
		self::assertInstanceOf(DnsRecord::class, $record);
		self::assertSame($this->getMatchingRecord(), $record->toArray());

		$notExistDnsRecord = new AaaaDnsRecord('AAAA', 'google.com', '1111:1450:5555:800::200e');
		self::assertFalse($records->hasRecord($notExistDnsRecord));

		self::assertTrue($records->hasSameRecords([$nsDnsRecord, $dnsRecord]));
		self::assertFalse($records->hasSameRecords([$nsDnsRecord, $notExistDnsRecord]));

		$byType = $records->getRecordsByType(DnsRecordType::MX);
		self::assertCount(2, $byType);
		self::assertInstanceOf(MxRecord::class, $byType[0]);
	}

	/**
	 * @return array<string>|array<int>
	 */
	private function getMatchingRecord(): array
	{
		return [
			'type' => 'AAAA',
			'name' => 'google.com',
			'content' => '2a00:1450:4014:800::200e',
			'ttl' => 300,
		];
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getDnsRecords(): array
	{
		return [
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 34,
				'type' => 'A',
				'ip' => '216.58.201.78',
			],
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 52_107,
				'type' => 'NS',
				'target' => 'ns3.google.com',
			],
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 30,
				'target' => 'alt2.aspmx.l.google.com',
			],
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 404,
				'type' => 'MX',
				'pri' => 10,
				'target' => 'aspmx.l.google.com',
			],
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 86_400,
				'type' => 'HINFO',
				'cpu' => 'CPU-type',
				'os' => 'linux-os',
			],
			[
				'host' => 'google.com',
				'class' => 'IN',
				'ttl' => 300,
				'type' => 'AAAA',
				'ipv6' => '2a00:1450:4014:800::200e',
			],
		];
	}

}
