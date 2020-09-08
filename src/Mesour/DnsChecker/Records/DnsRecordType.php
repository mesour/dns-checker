<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker;

/**
 * @author Matouš Němec <mesour.com>
 */
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

	/** @var int[] */
	private static $phpValues = [
		self::A => \DNS_A,
		self::AAAA => \DNS_AAAA,
		self::A6 => \DNS_A6,
		self::CAA => \DNS_CAA,
		self::CNAME => \DNS_CNAME,
		self::HINFO => \DNS_HINFO,
		self::MX => \DNS_MX,
		self::NAPTR => \DNS_NAPTR,
		self::NS => \DNS_NS,
		self::PTR => \DNS_PTR,
		self::SOA => \DNS_SOA,
		self::SRV => \DNS_SRV,
		self::TXT => \DNS_TXT,
	];

	/**
	 * @return string[]
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
		return \in_array($type, static::getAll(), true);
	}

	public static function getPhpValue(string $type): int
	{
		return static::$phpValues[$type] ?? \DNS_ALL;
	}

}
