<?php

namespace Mesour\DnsChecker\Diffs;

use Mesour\DnsChecker\IDnsRecord;

/**
 * @author Matouš Němec <mesour.com>
 */
class DnsRecordSetDiff
{

	/**
	 * @var DnsRecordDiff[]
	 */
	private $diffs;

	/**
	 * @param IDnsRecord[] $matches
	 */
	public function __construct(array $matches)
	{
		/** @var IDnsRecord $record */
		/** @var IDnsRecord|array $match */
		foreach ($matches as list ($record, $match)) {
			if (is_array($match)) {
				$this->diffs[] = new DnsRecordDiff($record, null, $match);
			} else {
				$this->diffs[] = new DnsRecordDiff($record, $match);
			}
		}
	}

	/**
	 * @return DnsRecordDiff[]
	 */
	public function getDiffs(): array
	{
		return $this->diffs;
	}

	/**
	 * @return bool
	 */
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
