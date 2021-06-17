VENDORBIN  := vendor/bin
PHPLOC     := $(VENDORBIN)/phploc
PHPCS      := $(VENDORBIN)/phpcs
PHPCPD     := $(VENDORBIN)/phpcpd
PHPMD      := $(VENDORBIN)/phpmd
PHPUNIT    := $(VENDORBIN)/phpunit
LARASTAN	:= $(VENDORBIN)/phpstan

all:
	@echo "Review the file 'Makefile' to see what targets are supported."

prepare:
	[ -d build ] || mkdir build
	rm -rf build/*

phploc: prepare
	$(PHPLOC) app routes tests resources database | tee build/phploc

phpcs: prepare
	[ ! -f .phpcs.xml ] || $(PHPCS) --standard=.phpcs.xml --extensions=php | tee build/phpcs

phpcpd: prepare
	$(PHPCPD) app routes tests resources database | tee build/phpcpd

phpmd: prepare
	- [ ! -f .phpmd.xml ] || $(PHPMD) app/Http/Controllers,app/Http/Requests,app/Models,app/Observers,routes/web.php,database/factories text .phpmd.xml | tee build/phpmd

larastan: prepare
	- $(LARASTAN) analyse --memory-limit=2G | tee build/larastan

laratest: prepare
	- php artisan test | tee build/laratest

lint: phpcs phpcpd phpmd larastan

metric: phploc

setup:
	- php artisan storage:link
	- php artisan migrate --force -vvv
	- php artisan migrate --env=testing --force -vvv
	- php artisan db:seed