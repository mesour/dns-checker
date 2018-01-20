<?php

namespace Mesour\DnsChecker;

/**
 * @author Matouš Němec <mesour.com>
 */
class DnsRecordSet implements \Iterator, \Countable, \ArrayAccess
{

	/**
	 * @var IDnsRecord[]
	 */
	private $dnsRecords;

	/**
	 * @var int
	 */
	private $position = 0;

	public function __construct(array $dnsRecords)
	{
		$this->dnsRecords = $dnsRecords;
	}

	public function getRecords()
	{
		return $this->dnsRecords;
	}

	public function isEmpty()
	{
		return count($this->dnsRecords) === 0;
	}

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
	public function getRecordsByType($type)
	{
		$out = [];
		foreach ($this->dnsRecords as $dnsRecord) {
			if ($dnsRecord->getType() === $type) {
				$out[] = $dnsRecord;
			}
		}
		return $out;
	}

	/**
	 * @param IDnsRecord $dnsRecord
	 * @return bool
	 */
	public function hasRecord(IDnsRecord $dnsRecord)
	{
		return $this->getMatchingRecord($dnsRecord) !== null;
	}

	/**
	 * @param IDnsRecord $checkedDnsRecord
	 * @return IDnsRecord|null
	 */
	public function getMatchingRecord(IDnsRecord $checkedDnsRecord)
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
	public function hasSameRecords(array $checkedRecords)
	{
		foreach ($this->dnsRecords as $dnsRecord) {
			if (count($checkedRecords) === 0) {
				break;
			}
			foreach ($checkedRecords as $key => $checkedRecord) {
				if ($this->areSame($dnsRecord, $checkedRecord)) {
					unset($checkedRecords[$key]);
				}
			}
		}
		return count($checkedRecords) === 0;
	}

	public function merge(DnsRecordSet $dnsRecordSet): DnsRecordSet
	{
		return new DnsRecordSet(array_merge($this->getRecords(), $dnsRecordSet->getRecords()));
	}

	public function count()
	{
		return count($this->dnsRecords);
	}

	public function rewind()
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

	public function next()
	{
		++$this->position;
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
		return isset($this->dnsRecords[$offset]) ? $this->dnsRecords[$offset] : null;
	}

	public function offsetSet($offset, $value)
	{
		throw new \RuntimeException('DnsRecordSet is read only.');
	}

	public function offsetUnset($offset)
	{
		throw new \RuntimeException('DnsRecordSet is read only.');
	}

	public function __clone()
	{
		$this->rewind();
	}

	private function areSame(IDnsRecord $first, IDnsRecord $second)
	{
		return $first->getType() === $second->getType() && $first->getContent() === $second->getContent();
	}

}
