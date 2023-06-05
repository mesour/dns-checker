_: list

# Config

PHPCS_CONFIG=ruleset.xml
PHPSTAN_CONFIG=phpstan.neon

# QA

qa: ## Check code quality - coding style and static analysis
	make lint && make cs && make phpstan && make phpunit

cs: ## Check PHP files coding style
	$(PRE_PHP) "vendor/bin/phpcs" src tests --standard=$(PHPCS_CONFIG) --parallel=$(LOGICAL_CORES) -d memory_limit=512M $(ARGS)

csf: ## Fix PHP files coding style
	$(PRE_PHP) "vendor/bin/phpcbf" src tests --standard=$(PHPCS_CONFIG) --parallel=$(LOGICAL_CORES) -d memory_limit=512M $(ARGS)

lint: ## Validate syntax of PHP files
	$(PRE_PHP) vendor/bin/parallel-lint src tests --blame -j $(LOGICAL_CORES)

phpstan: ## Analyse code with PHPStan
	$(PRE_PHP) "vendor/bin/phpstan" analyse src tests -c $(PHPSTAN_CONFIG) --memory-limit=512M $(ARGS)

phpunit: ## Analyse code with PHPStan
	$(PRE_PHP) "vendor/bin/phpunit" tests

# Utilities

.SILENT: $(shell grep -h -E '^[a-zA-Z_-]+:.*?$$' $(MAKEFILE_LIST) | sort -u | awk 'BEGIN {FS = ":.*?"}; {printf "%s ", $$1}')

LIST_PAD=20
list:
	awk 'BEGIN {FS = ":.*##"; printf "Usage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"}'
	grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort -u | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-$(LIST_PAD)s\033[0m %s\n", $$1, $$2}'

PRE_PHP=XDEBUG_MODE=off

LOGICAL_CORES=$(shell nproc || sysctl -n hw.logicalcpu || wmic cpu get NumberOfLogicalProcessors || echo 4)
