<?php

declare(strict_types = 1);

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

	public function testDefault(): void
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

		$notDifferent = $diffs[0];
		\assert($notDifferent instanceof DnsRecordDiff);
		Assert::false($notDifferent->isDifferent());
		Assert::same($this->getExpectedARecord(), $notDifferent->getExpectedRecord()->toArray());

		$different = $diffs[4];
		\assert($different instanceof DnsRecordDiff);
		Assert::true($different->isDifferent());
		Assert::same($this->getExpectedAAAARecord(), $different->getExpectedRecord()->toArray());
		Assert::count(0, $different->getSimilarRecords());

		$differentMx = $diffs[3];
		\assert($differentMx instanceof DnsRecordDiff);
		Assert::true($differentMx->isDifferent());
		Assert::same($this->getExpectedMxRecord(), $differentMx->getExpectedRecord()->toArray());
		Assert::count(2, $differentMx->getSimilarRecords());

		$similarRecord = $differentMx->getSimilarRecords()[1];
		\assert($similarRecord instanceof DnsRecord);
		Assert::type(DnsRecord::class, $similarRecord);
		Assert::same($this->getSimilarMxRecord(), $similarRecord->toArray());
	}

	/**
	 * @return string[]|int[]
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
	 * @return string[]|int[]
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
	 * @return string[]|int[]
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
	 * @return string[]|int[]
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
			Assert::type(DnsRecord::class, $item);
			$out[] = $item;
		}

		return new DnsRecordSet($out);
	}

	/**
	 * @return string[]|int[]
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

	/**
	 * @return string[]|int[]
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
