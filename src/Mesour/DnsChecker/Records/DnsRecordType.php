<?php

namespace Mesour\DnsChecker;

class DnsRecordType
{

	const A = 'A';
	const AAAA = 'AAAA';
	const A6 = 'A6';
	const CAA = 'CAA';
	const CNAME = 'CNAME';
	const HINFO = 'HINFO';
	const MX = 'MX';
	const NAPTR = 'NAPTR';
	const NS = 'NS';
	const PTR = 'PTR';
	const SOA = 'SOA';
	const SPF = 'SPF';
	const SRV = 'SRV';
	const TXT = 'TXT';

	/**
	 * @var int[]
	 */
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
	public static function getAll()
	{
		return [
			static::A,
			static::AAAA,
			static::A6,
			static::CAA,
			static::CNAME,
			static::HINFO,
			static::MX,
			static::NAPTR,
			static::NS,
			static::PTR,
			static::SOA,
			static::SPF,
			static::SRV,
			static::TXT,
		];
	}

	public static function isValid(string $type): bool
	{
		return in_array($type, static::getAll(), true);
	}

	public static function getPhpValue(string $type): int
	{
		return isset(static::$phpValues[$type]) ? static::$phpValues[$type] : \DNS_ALL;
	}

}
