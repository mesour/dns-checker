<?php declare(strict_types = 1);

namespace Mesour\DnsChecker\Diffs;

use Mesour\DnsChecker\IDnsRecord;
use function assert;
use function is_array;

class DnsRecordSetDiff
{

	/** @var array<DnsRecordDiff> */
	private array $diffs;

	/**
	 * @param array<IDnsRecord>|array<array<IDnsRecord>> $matches
	 */
	public function __construct(array $matches)
	{
		foreach ($matches as [$record, $match]) {
			assert($match instanceof IDnsRecord || is_array($match));
			$this->diffs[] = is_array($match)
				? new DnsRecordDiff($record, null, $match)
				: new DnsRecordDiff($record, $match);
		}
	}

	/**
	 * @return array<DnsRecordDiff>
	 */
	public function getDiffs(): array
	{
		return $this->diffs;
	}

	public function hasDifferentRecord(): bool
	{
		foreach ($this->diffs as $diff) {
			if ($diff->isDifferent()) {
				return true;
			}
		}

		return false;
	}

}
