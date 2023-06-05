<?php declare(strict_types = 1);

namespace Mesour\DnsChecker;

interface IDnsRecord
{

	public function getType(): string;

	public function getName(): string;

	public function getContent(): string;

	public function getTtl(): int;

	/**
	 * @return array<string>|array<int>
	 */
	public function toArray(): array;

}
