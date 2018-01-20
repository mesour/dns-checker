<?php

namespace Mesour\DnsChecker\Providers;

class DnsRecordProvider implements IDnsRecordProvider
{

	/**
	 * @param string $domain
	 * @param int $type
	 * @return array[]
	 * @throws
	 */
	public function getDnsRecordArray($domain, int $type = DNS_ANY): array
	{
		try {
			set_error_handler([$this, 'handleError']);
			$dns = dns_get_record($domain, $type);
			restore_error_handler();

		} catch (\Throwable $e) {
			if ($e->getMessage() !== 'dns_get_record(): A temporary server error occurred.') {
				throw $e;
			}
			$dns = [];
		}
		return $dns;
	}

	public function handleError($number, $message, $file, $line)
	{
		if (error_reporting() === 0) {
			return false;
		}
		throw new \ErrorException($message, 0, $number, $file, $line);
	}

}
