dev-test-units: composer-install-dev
	@vendor/bin/phpunit

composer-install-dev:
	@test ! -d vendor/phpunit/phpunit && composer install --dev || true

composer-update-dev:
	@composer update --dev

