<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

class SoaRecord extends DnsRecord
{

	private string $mname;

	private string $rname;

	private int $serial;

	private int $refresh;

	private int $retry;

	private int $expire;

	private int $minimumTtl;

	/**
	 * @param array<string>|array<int> $record
	 */
	public function __construct(array $record)
	{
		$this->mname = $record['mname'];
		$this->rname = $record['rname'];
		$this->serial = $record['serial'];
		$this->refresh = $record['refresh'];
		$this->retry = $record['retry'];
		$this->expire = $record['expire'];
		$this->minimumTtl = $record['minimum-ttl'];

		$content = $this->mname . ' ';
		$content .= $this->rname . ' ';
		$content .= $this->serial . ' ';
		$content .= $this->refresh . ' ';
		$content .= $this->retry . ' ';
		$content .= $this->expire . ' ';
		$content .= $this->minimumTtl;

		parent::__construct($record['type'], $record['host'], $content, $record['ttl']);
	}

	public function getMname(): string
	{
		return $this->mname;
	}

	public function getRname(): string
	{
		return $this->rname;
	}

	public function getSerial(): int
	{
		return $this->serial;
	}

	public function getRefresh(): int
	{
		return $this->refresh;
	}

	public function getRetry(): int
	{
		return $this->retry;
	}

	public function getExpire(): int
	{
		return $this->expire;
	}

	public function getMinimumTtl(): int
	{
		return $this->minimumTtl;
	}

}
