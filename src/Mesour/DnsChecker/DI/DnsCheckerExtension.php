<?php

declare(strict_types = 1);

namespace Mesour\DnsChecker\DI;

use Mesour\DnsChecker\Diffs\DnsRecordSetDiffFactory;
use Mesour\DnsChecker\DnsChecker;
use Mesour\DnsChecker\Providers\DnsRecordProvider;
use Mesour\DnsChecker\Providers\IDnsRecordProvider;
use Nette\DI\CompilerExtension;

/**
 * @author Matouš Němec <mesour.com>
 */
class DnsCheckerExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$container = $this->getContainerBuilder();

		$container->addDefinition($this->prefix('dnsChecker'))
			->setFactory(DnsChecker::class);

		$container->addDefinition($this->prefix('dnsRecordSetDiffFactory'))
			->setFactory(DnsRecordSetDiffFactory::class);

		$container->addDefinition($this->prefix('dnsRecordProvider'))
			->setType(IDnsRecordProvider::class)
			->setFactory(DnsRecordProvider::class);
	}

}
