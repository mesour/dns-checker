<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker;

/**
 * @author Matouš Němec <mesour.com>
 */
interface IDnsRecord
{

	public function getType(): string;

	public function getName(): string;

	public function getContent(): string;

	public function getTtl(): int;

	/**
	 * @return string[]|int[]
	 */
	public function toArray(): array;

}
