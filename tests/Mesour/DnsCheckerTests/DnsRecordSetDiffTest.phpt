<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\Diffs\DnsRecordDiff;
use Mesour\DnsChecker\Diffs\DnsRecordSetDiffFactory;
use Mesour\DnsChecker\DnsRecord;
use Mesour\DnsChecker\DnsRecordSet;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class DnsRecordSetDiffTest extends BaseTestCase
{

	public function testDefault()
	{
		$factory = new DnsRecordSetDiffFactory();

		$expected = $this->createExpectedDnsRecordSet();

		$checker = $this->createChecker($this->getDnsRecords());
		$recordSet = $checker->getDnsRecordSet('example.com');

		$diff = $factory->createDiff($expected, $recordSet);

		Assert::true($diff->hasDifferentRecord());

		$diffs = $diff->getDiffs();

		Assert::count(5, $diffs);
		Assert::type(DnsRecordDiff::class, $diffs[0]);

		/** @var DnsRecordDiff $notDifferent */
		$notDifferent = $diffs[0];
		Assert::false($notDifferent->isDifferent());
		Assert::same($this->getExpectedARecord(), $notDifferent->getExpectedRecord()->toArray());

		/** @var DnsRecordDiff $different */
		$different = $diffs[4];
		Assert::true($different->isDifferent());
		Assert::same($this->getExpectedAAAARecord(), $different->getExpectedRecord()->toArray());
		Assert::count(0, $different->getSimilarRecords());

		/** @var DnsRecordDiff $differentMx */
		$differentMx = $diffs[3];
		Assert::true($differentMx->isDifferent());
		Assert::same($this->getExpectedMxRecord(), $differentMx->getExpectedRecord()->toArray());
		Assert::count(1, $differentMx->getSimilarRecords());

		/** @var DnsRecord $similarRecord */
		$similarRecord = $differentMx->getSimilarRecords()[0];
		Assert::type(DnsRecord::class, $similarRecord);
		Assert::same($this->getSimilarMxRecord(), $similarRecord->toArray());
	}

	private function getExpectedARecord(): array
	{
		return [
			'type' => 'A',
			'name' => 'example.com',
			'content' => '216.58.201.78',
			'ttl' => 34,
		];
	}

	private function getExpectedAAAARecord(): array
	{
		return [
			'type' => 'AAAA',
			'name' => 'example.com',
			'content' => '2a00:5565:4444:800::200e',
			'ttl' => 300,
		];
	}

	private function getExpectedMxRecord(): array
	{
		return [
			'type' => 'MX',
			'name' => 'example.com',
			'content' => '10 aspmx.example.com',
			'ttl' => 404,
		];
	}

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
			Assert::type(DnsRecord::class, $item);
			$out[] = $item;
		}
		return new DnsRecordSet($out);
	}

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
		];
	}

}

$test = new DnsRecordSetDiffTest();
$test->run();
