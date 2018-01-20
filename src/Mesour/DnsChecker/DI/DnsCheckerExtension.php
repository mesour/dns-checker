<?php

namespace Mesour\DnsProvider\DI;

use Mesour\DnsProvider\DnsChecker;
use Mesour\DnsProvider\Providers\DnsRecordProvider;
use Mesour\DnsProvider\Providers\IDnsRecordProvider;
use Nette\DI\CompilerExtension;

class DnsCheckerExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();

		$container->addDefinition($this->prefix('dnsChecker'))
			->setFactory(DnsChecker::class);

		$container->addDefinition($this->prefix('dnsRecordProvider'))
			->setType(IDnsRecordProvider::class)
			->setFactory(DnsRecordProvider::class);
	}

}
