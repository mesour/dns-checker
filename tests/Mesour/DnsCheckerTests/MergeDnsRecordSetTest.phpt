<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\DnsChecker;
use Mesour\DnsChecker\DnsRecord;
use Mesour\DnsChecker\DnsRecordRequest;
use Mesour\DnsChecker\DnsRecordType;
use Mesour\DnsChecker\MxRecord;
use Mesour\DnsChecker\Providers\ArrayDnsRecordProvider;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class MergeDnsRecordSetTest extends BaseTestCase
{

	public function testDefault()
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

		Assert::false($records->isEmpty());
		Assert::count(7, $records);

		$nsDnsRecord = new DnsRecord('NS', 'example.com', 'ns3.example.com');
		Assert::true($records->hasRecord($nsDnsRecord));

		$dnsRecord = new DnsRecord('AAAA', 'example.com', '2a00:1450:4014:800::200e');
		Assert::false($records->hasRecord($dnsRecord));

		$dnsRecord = new DnsRecord('CNAME', 'www.example.com', 'example.com');
		Assert::true($records->hasRecord($dnsRecord));

		$record = $records->getMatchingRecord($dnsRecord);
		Assert::type(DnsRecord::class, $record);
		Assert::same($this->getMatchingRecord(), $record->toArray());

		$notExistDnsRecord = new DnsRecord('AAAA', 'example.com', '1111:1450:5555:800::200e');
		Assert::false($records->hasRecord($notExistDnsRecord));

		Assert::true($records->hasSameRecords([$nsDnsRecord, $dnsRecord]));
		Assert::false($records->hasSameRecords([$nsDnsRecord, $notExistDnsRecord]));

		$byType = $records->getRecordsByType(DnsRecordType::MX);
		Assert::count(2, $byType);
		Assert::type(MxRecord::class, $byType[0]);
	}

	private function getMatchingRecord(): array
	{
		return [
			'type' => 'CNAME',
			'name' => 'www.example.com',
			'content' => 'example.com',
			'ttl' => 1800,
		];
	}

	private function getCnameDnsRecords(): array
	{
		return [
			[
				'host' => 'www.example.com',
				'class' => 'IN',
				'ttl' => 1800,
				'type' => 'CNAME',
				'target' => 'example.com',
			],
		];
	}

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
				'ttl' => 52107,
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
				'ttl' => 86400,
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

$test = new MergeDnsRecordSetTest();
$test->run();
