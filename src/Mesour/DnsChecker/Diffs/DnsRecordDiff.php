<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker\Diffs;

use Mesour\DnsChecker\IDnsRecord;

/**
 * @author Matouš Němec <mesour.com>
 */
class DnsRecordDiff
{

	/** @var IDnsRecord */
	private $expected;

	/** @var IDnsRecord|null */
	private $actual;

	/** @var IDnsRecord[] */
	private $sameType;

	/**
	 * @param IDnsRecord $expected
	 * @param IDnsRecord|null $actual
	 * @param IDnsRecord[] $sameType
	 */
	public function __construct(IDnsRecord $expected, ?IDnsRecord $actual = null, array $sameType = [])
	{
		$this->expected = $expected;
		$this->actual = $actual;
		$this->sameType = $sameType;
	}

	public function isDifferent(): bool
	{
		return $this->actual === null;
	}

	public function getExpectedRecord(): IDnsRecord
	{
		return $this->expected;
	}

	public function getActualRecord(): ?IDnsRecord
	{
		return $this->actual;
	}

	/**
	 * @return IDnsRecord[]
	 */
	public function getSimilarRecords(): array
	{
		return $this->sameType;
	}

}
