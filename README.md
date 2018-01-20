# Mesour DNS checker

- [Author](http://mesour.com)

- DNS checker written in PHP for check and compare real DNS records for domain.

- Problem with PHP warning: `dns_get_record(): A temporary server error occurred.` is resolved.

# Install

- With [Composer](https://getcomposer.org)

        composer require mesour/dns-checker

- Or download source from [GitHub](https://github.com/mesour/dns-checker/releases)

# Usage

1. Create instance `\Mesour\DnsChecker\Providers\DnsRecordProvider`:

```php
$provider = new \Mesour\DnsChecker\Providers\DnsRecordProvider();
```

2. Create instance `\Mesour\DnsChecker\DnsChecker`:

```php
$checker = new \Mesour\DnsChecker\DnsChecker($provider);
```

3. Get DNS record set (second parameter `type` have same values as parameter `type` for [PHP function dns_get_record()](http://php.net/manual/en/function.dns-get-record.php).):

```php
$dnsRecordSet = $checker->getDnsRecordSet('example.com', DNS_A + DNS_AAAA);
```

`$dnsRecordSet` contains for example:

```
Mesour\DnsChecker\DnsRecordSet
   dnsRecords private => array (3)
   |  0 => Mesour\DnsChecker\MxRecord #86b8
   |  |  priority private => 40
   |  |  target private => "alt3.aspmx.l.example.com" (24)
   |  |  type private => "MX" (2)
   |  |  name private => "example.com" (11)
   |  |  content private => "40 alt3.aspmx.l.example.com" (27)
   |  |  ttl private => 404
   |  1 => Mesour\DnsChecker\MxRecord #5a7b
   |  |  priority private => 50
   |  |  target private => "alt4.aspmx.l.example.com" (24)
   |  |  type private => "MX" (2)
   |  |  name private => "example.com" (11)
   |  |  content private => "50 alt4.aspmx.l.example.com" (27)
   |  |  ttl private => 404
```

# DnsRecordSet

- Implements `\ArrayAccess`, `\Countable` and `\Iterator`.

Check if exist domain record:

```php
$dnsRecord = new \Mesour\DnsChecker\Records\DnsRecord('NS', 'example.com', 'ns3.example.com');
Assert::true($dnsRecordSet->hasRecord($dnsRecord));
```

Get matching DNS record:

```php
$dnsRecord = new \Mesour\DnsChecker\Records\DnsRecord('AAAA', 'example.com', '2a00:4444:5555:6666::200e');
$nsDnsRecord = $dnsRecordSet->getMatchingRecord($dnsRecord);
```

## More information in one DnsRecordSet

```php
$request = new DnsRecordRequest();
$request->addFilter('example.com');
$request->addFilter('www.example.com', DNS_CNAME);
// ... more lines

/** @var \Mesour\DnsChecker\DnsChecker $checker */
/** @var \Mesour\DnsChecker\DnsRecordSet $records */
$records = $checker->getDnsRecordSetFromRequest($request);
```

# Tests

Run command `vendor/bin/tester tests/ -s -c tests/php.ini --colors`

## PHP Stan

Run command `vendor/bin/phpstan analyse -l 7 -c phpstan.neon src tests`

## Code style

Run command `vendor/bin/phpcs --standard=ruleset.xml --extensions=php,phpt --encoding=utf-8 --tab-width=4 -sp src tests`

## Mock DNS record provider

For mock DNS provider your tests can use `Mesour\DnsChecker\StaticDnsRecordProvider` or `Mesour\DnsChecker\ArrayDnsRecordProvider`.

Values are as return values of [PHP function dns_get_record()](http://php.net/manual/en/function.dns-get-record.php).

```php
$provider = new \Mesour\DnsChecker\Providers\StaticDnsRecordProvider([
	[
    	'host' => 'example.com',
    	'class' => 'IN',
    	'ttl' => 34,
    	'type' => 'A',
    	'ip' => '216.58.201.78',
    ],
]);
```
