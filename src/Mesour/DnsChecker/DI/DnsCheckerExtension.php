<?php

namespace Mesour\DnsChecker\DI;

use Mesour\DnsChecker\DnsChecker;
use Mesour\DnsChecker\Providers\DnsRecordProvider;
use Mesour\DnsChecker\Providers\IDnsRecordProvider;
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
