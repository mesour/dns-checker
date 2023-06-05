<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

use function in_array;
use const DNS_A;
use const DNS_A6;
use const DNS_AAAA;
use const DNS_ALL;
use const DNS_CAA;
use const DNS_CNAME;
use const DNS_HINFO;
use const DNS_MX;
use const DNS_NAPTR;
use const DNS_NS;
use const DNS_PTR;
use const DNS_SOA;
use const DNS_SRV;
use const DNS_TXT;

class DnsRecordType
{

	public const A = 'A';

	public const AAAA = 'AAAA';

	public const A6 = 'A6';

	public const CAA = 'CAA';

	public const CNAME = 'CNAME';

	public const HINFO = 'HINFO';

	public const MX = 'MX';

	public const NAPTR = 'NAPTR';

	public const NS = 'NS';

	public const PTR = 'PTR';

	public const SOA = 'SOA';

	public const SPF = 'SPF';

	public const SRV = 'SRV';

	public const TXT = 'TXT';

	/** @var array<int> */
	private static array $phpValues = [
		self::A => DNS_A,
		self::AAAA => DNS_AAAA,
		self::A6 => DNS_A6,
		self::CAA => DNS_CAA,
		self::CNAME => DNS_CNAME,
		self::HINFO => DNS_HINFO,
		self::MX => DNS_MX,
		self::NAPTR => DNS_NAPTR,
		self::NS => DNS_NS,
		self::PTR => DNS_PTR,
		self::SOA => DNS_SOA,
		self::SRV => DNS_SRV,
		self::TXT => DNS_TXT,
	];

	/**
	 * @return array<string>
	 */
	public static function getAll(): array
	{
		return [
			self::A,
			self::AAAA,
			self::A6,
			self::CAA,
			self::CNAME,
			self::HINFO,
			self::MX,
			self::NAPTR,
			self::NS,
			self::PTR,
			self::SOA,
			self::SPF,
			self::SRV,
			self::TXT,
		];
	}

	public static function isValid(string $type): bool
	{
		return in_array($type, static::getAll(), true);
	}

	public static function getPhpValue(string $type): int
	{
		return self::$phpValues[$type] ?? DNS_ALL;
	}

}
