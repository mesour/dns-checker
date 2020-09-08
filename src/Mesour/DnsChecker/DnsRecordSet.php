<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker;

/**
 * @author Matouš Němec <mesour.com>
 */
class DnsRecordSet implements \Iterator, \Countable, \ArrayAccess
{

	/** @var IDnsRecord[] */
	private $dnsRecords;

	/** @var int */
	private $position = 0;

	/**
	 * @param IDnsRecord[] $dnsRecords
	 */
	public function __construct(array $dnsRecords)
	{
		$this->dnsRecords = $dnsRecords;
	}

	/**
	 * @return IDnsRecord[]
	 */
	public function getRecords(): array
	{
		return $this->dnsRecords;
	}

	public function isEmpty(): bool
	{
		return \count($this->dnsRecords) === 0;
	}

	/**
	 * @return string[][]|int[][]
	 */
	public function toArray(): array
	{
		$out = [];

		foreach ($this->dnsRecords as $dnsRecord) {
			$out[] = $dnsRecord->toArray();
		}

		return $out;
	}

	/**
	 * @param string $type
	 * @return IDnsRecord[]
	 */
	public function getRecordsByType(string $type): array
	{
		$out = [];

		foreach ($this->dnsRecords as $dnsRecord) {
			if ($dnsRecord->getType() !== $type) {
				continue;
			}

			$out[] = $dnsRecord;
		}

		return $out;
	}

	public function hasRecord(IDnsRecord $dnsRecord): bool
	{
		return $this->getMatchingRecord($dnsRecord) !== null;
	}

	public function getMatchingRecord(IDnsRecord $checkedDnsRecord): ?IDnsRecord
	{
		foreach ($this->dnsRecords as $dnsRecord) {
			if ($this->areSame($dnsRecord, $checkedDnsRecord)) {
				return $dnsRecord;
			}
		}

		return null;
	}

	/**
	 * @param IDnsRecord[] $checkedRecords
	 * @return bool
	 */
	public function hasSameRecords(array $checkedRecords): bool
	{
		foreach ($this->dnsRecords as $dnsRecord) {
			if (\count($checkedRecords) === 0) {
				break;
			}

			foreach ($checkedRecords as $key => $checkedRecord) {
				if (!$this->areSame($dnsRecord, $checkedRecord)) {
					continue;
				}

				unset($checkedRecords[$key]);
			}
		}

		return \count($checkedRecords) === 0;
	}

	public function merge(DnsRecordSet $dnsRecordSet): DnsRecordSet
	{
		return new DnsRecordSet(\array_merge($this->getRecords(), $dnsRecordSet->getRecords()));
	}

	public function count()
	{
		return \count($this->dnsRecords);
	}

	public function rewind(): void
	{
		$this->position = 0;
	}

	public function current()
	{
		return $this->dnsRecords[$this->position];
	}

	public function key()
	{
		return $this->position;
	}

	public function next(): void
	{
		$this->position++;
	}

	public function valid()
	{
		return isset($this->dnsRecords[$this->position]);
	}

	public function offsetExists($offset)
	{
		return isset($this->dnsRecords[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->dnsRecords[$offset] ?? null;
	}

	public function offsetSet($offset, $value): void
	{
		throw new \RuntimeException('DnsRecordSet is read only.');
	}

	public function offsetUnset($offset): void
	{
		throw new \RuntimeException('DnsRecordSet is read only.');
	}

	private function areSame(IDnsRecord $first, IDnsRecord $second): bool
	{
		return $first->getType() === $second->getType() && $first->getContent() === $second->getContent();
	}

	public function __clone()
	{
		$this->rewind();
	}

}
