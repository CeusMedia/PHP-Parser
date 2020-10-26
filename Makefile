dev-test-units: composer-install-dev
	@vendor/bin/phpunit


composer-install-dev:
	@composer install

