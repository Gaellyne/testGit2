php bin/console doctrine:database:drop --if-exists --force --env=dev
php bin/console doctrine:database:create --env=dev
php bin/console doctrine:schema:create --env=dev
rm -rf var/cache/*
rm -rf var/logs/*
rm -rf var/sessions/*
php bin/console d:m:m --no-interaction