<?php declare(strict_types = 1);

namespace Mesour\DnsChecker\Diffs;

use Mesour\DnsChecker\DnsRecordSet;
use Mesour\DnsChecker\IDnsRecord;
use function in_array;
use function is_array;

class DnsRecordSetDiffFactory
{

	public function createDiff(DnsRecordSet $expected, DnsRecordSet $actual): DnsRecordSetDiff
	{
		$matches = [];

		foreach ($expected->getRecords() as $record) {
			$actualRecord = $actual->getMatchingRecord($record);

			$matches[] = $actualRecord !== null
				? [$record, $actualRecord]
				: $record;
		}

		$actualNotMatched = $this->getActualNotMatched($actual, $matches);

		foreach ($matches as &$record) {
			if (!$record instanceof IDnsRecord) {
				continue;
			}

			$record = [$record, $actualNotMatched->getRecordsByType($record->getType())];
		}

		return new DnsRecordSetDiff($matches);
	}

	/**
	 * @param array<string>|array<int>|array<IDnsRecord>|array<array<IDnsRecord>> $matches
	 */
	private function getActualNotMatched(DnsRecordSet $actual, array $matches): DnsRecordSet
	{
		$forCheck = [];

		foreach ($matches as $match) {
			if (!is_array($match)) {
				continue;
			}

			$forCheck[] = $match[0];
		}

		$out = [];

		foreach ($actual->getRecords() as $record) {
			if (in_array($record, $forCheck, true)) {
				continue;
			}

			$out[] = $record;
		}

		return new DnsRecordSet($out);
	}

}
