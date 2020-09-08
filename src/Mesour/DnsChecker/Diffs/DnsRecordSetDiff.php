<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker\Diffs;

use Mesour\DnsChecker\IDnsRecord;

/**
 * @author Matouš Němec <mesour.com>
 */
class DnsRecordSetDiff
{

	/** @var DnsRecordDiff[] */
	private $diffs;

	/**
	 * @param IDnsRecord[] $matches
	 */
	public function __construct(array $matches)
	{
		foreach ($matches as [$record, $match]) {
			\assert($match instanceof IDnsRecord || \is_array($match));
			$this->diffs[] = \is_array($match) ? new DnsRecordDiff($record, null, $match) : new DnsRecordDiff(
				$record,
				$match
			);
		}
	}

	/**
	 * @return DnsRecordDiff[]
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
