dev-test-units: composer-install-dev
	@vendor/bin/phpunit



# --  COMPOSER  -----------------------------------------------------------
composer-install-dev:
	@composer install --dev

composer-install-nodev:
	@composer install --no-dev

composer-update-dev:
	@composer update --dev

composer-update-nodev:
	@composer update --no--dev


# --  DEV: QUALITY--------------------------------------------------------
dev-phpstan:
	@vendor/bin/phpstan analyse --configuration phpstan.neon --xdebug || true

dev-phpstan-save-baseline:
	@vendor/bin/phpstan analyse --configuration phpstan.neon --generate-baseline phpstan-baseline.neon || true

