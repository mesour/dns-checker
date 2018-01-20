<?php

namespace Mesour\DnsChecker\IpAddresses;

class IpAddressValidator
{

	public function __construct()
	{
		throw new \RuntimeException('IpAddressValidator is static class');
	}

	public static function isIpAddress(string $ipAddress): bool
	{
		return (bool) filter_var($ipAddress, FILTER_VALIDATE_IP);
	}

	public static function isIpV4(string $ipAddress): bool
	{
		return (bool) filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
	}

	public static function isIpV6(string $ipAddress): bool
	{
		return (bool) filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
	}

}
