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

	/**
	 * @param string $type
	 * @return bool
	 */
	public static function isValid($type)
	{
		return in_array($type, static::getAll(), true);
	}

}
