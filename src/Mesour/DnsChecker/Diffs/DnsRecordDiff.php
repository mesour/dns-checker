<?php declare(strict_types = 1);

namespace Mesour\DnsChecker\Diffs;

use Mesour\DnsChecker\IDnsRecord;

class DnsRecordDiff
{

	/**
	 * @param array<IDnsRecord> $sameType
	 */
	public function __construct(
		private IDnsRecord $expected,
		private IDnsRecord|null $actual = null,
		private array $sameType = [],
	)
	{
	}

	public function isDifferent(): bool
	{
		return $this->actual === null;
	}

	public function getExpectedRecord(): IDnsRecord
	{
		return $this->expected;
	}

	public function getActualRecord(): IDnsRecord|null
	{
		return $this->actual;
	}

	/**
	 * @return array<IDnsRecord>
	 */
	public function getSimilarRecords(): array
	{
		return $this->sameType;
	}

}
