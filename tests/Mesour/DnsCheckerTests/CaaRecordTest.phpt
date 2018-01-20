<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsProvider\CaaRecord;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class CaaRecordTest extends BaseTestCase
{

	public function testDefault()
	{
		$checker = $this->createChecker($this->getDnsRows());
		$records = $checker->getDnsRecordSet('example.com');

		Assert::false($records->isEmpty());
		Assert::count(1, $records);
		Assert::type(CaaRecord::class, $records[0]);
		Assert::same($this->getExpectedRows(), $records->toArray());
	}

	private function getExpectedRows(): array
	{
		return [
			[
				'type' => 'CAA',
				'name' => 'example.com',
				'content' => "0 issue pki.goog\xc0\x0c",
				'ttl' => 86400,
			],
		];
	}

	private function getDnsRows(): array
	{
		return [
			[
				'host' => 'example.com',
				'class' => 'IN',
				'ttl' => 86400,
				'type' => 'CAA',
				'flags' => 0,
				'tag' => 'issue',
				'value' => "pki.goog\xc0\x0c",
			],
		];
	}

}

$test = new CaaRecordTest();
$test->run();
