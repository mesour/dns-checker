<?php declare(strict_types = 1);

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\DnsChecker;
use Mesour\DnsChecker\DnsRecord;
use Mesour\DnsChecker\DnsRecordRequest;
use Mesour\DnsChecker\DnsRecordType;
use Mesour\DnsChecker\MxRecord;
use Mesour\DnsChecker\Providers\ArrayDnsRecordProvider;
use const DNS_CNAME;

class MergeDnsRecordSetTest extends BaseTestCase
{

	public function testDefault(): void
	{
		$provider = new ArrayDnsRecordProvider([
			$this->getDnsRecords(),
			$this->getCnameDnsRecords(),
		]);
		$checker = new DnsChecker($provider);

		$request = new DnsRecordRequest();
		$request->addFilter('example.com');
		$request->addFilter('www.example.com', DNS_CNAME);
		$records = $checker->getDnsRecordSetFromRequest($request);

		self::assertFalse($records->isEmpty());
		self::assertCount(7, $records);

		$nsDnsRecord = new DnsRecord('NS', 'example.com', 'ns3.example.com');
		self::assertTrue($records->hasRecord($nsDnsRecord));

		$dnsRecord = new DnsRecord('AAAA', 'example.com', '2a00:1450:4014:800::200e');
		self::assertFalse($records->hasRecord($dnsRecord));

		$dnsRecord = new DnsRecord('CNAME', 'www.example.com', 'example.com');
		self::assertTrue($records->hasRecord($dnsRecord));

		$record = $records->getMatchingRecord($dnsRecord);
		self::assertInstanceOf(DnsRecord::class, $record);
		self::assertSame($this->getMatchingRecord(), $record->toArray());

		$notExistDnsRecord = new DnsRecord('AAAA', 'example.com', '1111:1450:5555:800::200e');
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
			'type' => 'CNAME',
			'name' => 'www.example.com',
			'content' => 'example.com',
			'ttl' => 1_800,
		];
	}

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	private function getCnameDnsRecords(): array
	{
		return [
			[
				'host' => 'www.example.com',
				'class' => 'IN',
				'ttl' => 1_800,
				'type' => 'CNAME',
				'target' => 'example.com',
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
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 86_400,
				'type' => 'HINFO',
				'cpu' => 'CPU-type',
				'os' => 'linux-os',
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

}
