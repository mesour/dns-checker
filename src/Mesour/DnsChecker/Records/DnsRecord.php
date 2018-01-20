<?php

namespace Mesour\DnsChecker;

class DnsRecord implements IDnsRecord
{

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var int
	 */
	private $ttl;

	public function __construct(string $type, string $name, string $content, int $ttl = 1800)
	{
		$type = strtoupper($type);
		if (!DnsRecordType::isValid($type)) {
			throw new \InvalidArgumentException('Invalid DNS row type');
		}
		$this->type = $type;
		$this->name = $name;
		$this->content = $content;
		$this->ttl = $ttl;
	}

	/**
	 * @param array $record
	 * @return IDnsRecord|null
	 */
	public static function fromPhpArray(array $record): IDnsRecord
	{
		$type = $record['type'];
		if ($type === DnsRecordType::A) {
			$content = $record['ip'];
		} elseif ($type === DnsRecordType::AAAA) {
			return new AaaaDnsRecord($type, $record['host'], $record['ipv6'], $record['ttl']);
		} elseif (in_array($type, [DnsRecordType::CNAME, DnsRecordType::NS, DnsRecordType::PTR], true)) {
			$content = $record['target'];
		} elseif ($type === DnsRecordType::TXT) {
			$content = $record['txt'];
		} elseif ($type === DnsRecordType::MX) {
			return new MxRecord($record);
		} elseif ($type === DnsRecordType::SOA) {
			return new SoaRecord($record);
		} elseif ($type === DnsRecordType::CAA) {
			return new CaaRecord($record);
		} elseif ($type === DnsRecordType::HINFO) {
			return new HInfoRecord($record);
		} elseif ($type === DnsRecordType::SRV) {
			return new SrvRecord($record);
		} elseif ($type === DnsRecordType::A6) {
			return new A6Record($record);
		} else {
			throw new \RuntimeException(sprintf('Dns record type %s is not implemented', $type));
		}

		return new static($type, $record['host'], $content, $record['ttl']);
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getContent(): string
	{
		return $this->content;
	}

	public function getTtl(): int
	{
		return $this->ttl;
	}

	public function toArray(): array
	{
		return [
			'type' => $this->getType(),
			'name' => $this->getName(),
			'content' => $this->getContent(),
			'ttl' => $this->getTtl(),
		];
	}

}
