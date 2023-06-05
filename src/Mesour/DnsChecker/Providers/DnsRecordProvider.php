<?php declare(strict_types = 1);

namespace Mesour\DnsChecker\Providers;

use ErrorException;
use Throwable;
use function dns_get_record;
use function error_reporting;
use function restore_error_handler;
use function set_error_handler;
use const DNS_ANY;

class DnsRecordProvider implements IDnsRecordProvider
{

	/**
	 * @return array<array<string>>|array<array<int>>
	 */
	public function getDnsRecordArray(string $domain, int $type = DNS_ANY): array
	{
		try {
			set_error_handler([$this, 'handleError']);
			$dns = dns_get_record($domain, $type);
			restore_error_handler();

		} catch (Throwable $e) {
			if ($e->getMessage() !== 'dns_get_record(): A temporary server error occurred.') {
				throw $e;
			}

			$dns = [];
		}

		return $dns === false ? [] : $dns;
	}

	public function handleError(int $number, string $message, string $file, int $line): bool
	{
		if (error_reporting() === 0) {
			return false;
		}

		throw new ErrorException($message, 0, $number, $file, $line);
	}

}
