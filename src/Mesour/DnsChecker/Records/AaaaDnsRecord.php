<?php

namespace Mesour\DnsChecker;

use Mesour\DnsChecker\IpAddresses\IpAddressNormalizer;

class AaaaDnsRecord extends DnsRecord
{

	public function __construct(string $type, string $name, string $content, int $ttl = 1800)
	{
		parent::__construct($type, $name, IpAddressNormalizer::compressIpV6($content), $ttl);
	}

}
