<?php

namespace Mesour\DnsChecker;

class SoaRecord extends DnsRecord
{

	/**
	 * @var string
	 */
	private $mname;

	/**
	 * @var string
	 */
	private $rname;

	/**
	 * @var int
	 */
	private $serial;

	/**
	 * @var int
	 */
	private $refresh;

	/**
	 * @var int
	 */
	private $retry;

	/**
	 * @var int
	 */
	private $expire;

	/**
	 * @var int
	 */
	private $minimumTtl;

	/**
	 * @param array $record
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
