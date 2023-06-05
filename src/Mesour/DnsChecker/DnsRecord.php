<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

use InvalidArgumentException;
use RuntimeException;
use function in_array;
use function sprintf;
use function strtoupper;

class DnsRecord implements IDnsRecord
{

	private string $type;

	public function __construct(string $type, private string $name, private string $content, private int $ttl = 1_800)
	{
		$type = strtoupper($type);

		if (!DnsRecordType::isValid($type)) {
			throw new InvalidArgumentException('Invalid DNS row type');
		}

		$this->type = $type;
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

	/**
	 * @return array<string>|array<int>
	 */
	public function toArray(): array
	{
		return [
			'type' => $this->getType(),
			'name' => $this->getName(),
			'content' => $this->getContent(),
			'ttl' => $this->getTtl(),
		];
	}

	/**
	 * @param array<string>|array<int> $record
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
			throw new RuntimeException(sprintf('Dns record type %s is not implemented', $type));
		}

		return new self($type, $record['host'], $content, $record['ttl']);
	}

}
