<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

use ArrayAccess;
use Countable;
use Iterator;
use RuntimeException;
use function array_merge;
use function count;

class DnsRecordSet implements Iterator, Countable, ArrayAccess
{

	private int $position = 0;

	/**
	 * @param array<IDnsRecord> $dnsRecords
	 */
	public function __construct(private array $dnsRecords)
	{
	}

	/**
	 * @return array<IDnsRecord>
	 */
	public function getRecords(): array
	{
		return $this->dnsRecords;
	}

	public function isEmpty(): bool
	{
		return count($this->dnsRecords) === 0;
	}

	/**
	 * @return array<array<string>>|array<array<int>>
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
	 * @return array<IDnsRecord>
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

	public function getMatchingRecord(IDnsRecord $checkedDnsRecord): IDnsRecord|null
	{
		foreach ($this->dnsRecords as $dnsRecord) {
			if ($this->areSame($dnsRecord, $checkedDnsRecord)) {
				return $dnsRecord;
			}
		}

		return null;
	}

	/**
	 * @param array<IDnsRecord> $checkedRecords
	 */
	public function hasSameRecords(array $checkedRecords): bool
	{
		foreach ($this->dnsRecords as $dnsRecord) {
			if (count($checkedRecords) === 0) {
				break;
			}

			foreach ($checkedRecords as $key => $checkedRecord) {
				if (!$this->areSame($dnsRecord, $checkedRecord)) {
					continue;
				}

				unset($checkedRecords[$key]);
			}
		}

		return count($checkedRecords) === 0;
	}

	public function merge(self $dnsRecordSet): self
	{
		return new self(array_merge($this->getRecords(), $dnsRecordSet->getRecords()));
	}

	public function count(): int
	{
		return count($this->dnsRecords);
	}

	public function rewind(): void
	{
		$this->position = 0;
	}

	public function current(): IDnsRecord
	{
		return $this->dnsRecords[$this->position];
	}

	public function key(): int
	{
		return $this->position;
	}

	public function next(): void
	{
		$this->position++;
	}

	public function valid(): bool
	{
		return isset($this->dnsRecords[$this->position]);
	}

	public function offsetExists($offset): bool
	{
		return isset($this->dnsRecords[$offset]);
	}

	public function offsetGet($offset): IDnsRecord
	{
		if (!isset($this->dnsRecords[$offset])) {
			throw new RuntimeException('Offset ' . $offset . ' not exists');
		}

		return $this->dnsRecords[$offset];
	}

	public function offsetSet($offset, $value): void
	{
		throw new RuntimeException('DnsRecordSet is read only.');
	}

	public function offsetUnset($offset): void
	{
		throw new RuntimeException('DnsRecordSet is read only.');
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
