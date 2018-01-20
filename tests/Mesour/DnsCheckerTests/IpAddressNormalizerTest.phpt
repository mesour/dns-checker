<?php

namespace Mesour\DnsCheckerTests;

use Mesour\DnsChecker\IpAddresses\IpAddressNormalizer;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/BaseTestCase.php';

class IpAddressNormalizerTest extends BaseTestCase
{

	public function testCompress()
	{
		Assert::same(
			'2001:db8::ff00:42:8329',
			IpAddressNormalizer::compressIpV6('2001:0db8:0000:0000:0000:ff00:0042:8329')
		);

		Assert::same(
			'2001:db8:800::ff00:42:8329',
			IpAddressNormalizer::compressIpV6('2001:0db8:0800:0000:0000:ff00:0042:8329')
		);

		Assert::same(
			'0:db8:800::ff00:42:8329',
			IpAddressNormalizer::compressIpV6('0000:0db8:0800:0000:0000:ff00:0042:8329')
		);

		Assert::same(
			'f000:db8:800::ff00:42:0',
			IpAddressNormalizer::compressIpV6('f000:0db8:0800:0000:0000:ff00:0042:0000')
		);
	}

	public function testNormalize()
	{
		Assert::same(
			'2001:0db8:0000:0000:0000:ff00:0042:8329',
			IpAddressNormalizer::normalizeIpV6('2001:db8::ff00:42:8329')
		);

		Assert::same(
			'2001:0db8:0800:0000:0000:ff00:0042:8329',
			IpAddressNormalizer::normalizeIpV6('2001:db8:800::ff00:42:8329')
		);

		Assert::same(
			'0000:0db8:0800:0000:0000:ff00:0042:8329',
			IpAddressNormalizer::normalizeIpV6('0:db8:800::ff00:42:8329')
		);

		Assert::same(
			'f000:0db8:0800:0000:0000:ff00:0042:0000',
			IpAddressNormalizer::normalizeIpV6('f000:db8:800::ff00:42:0')
		);
	}

}

$test = new IpAddressNormalizerTest();
$test->run();
