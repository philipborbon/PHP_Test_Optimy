# PHP Test
 
## Prerequisites
- PHP 8.2
- Composer
- Xdebug (For test coverage)
 
## Installation
- Create 2 empty db, `phptest` and `phptest_tests`
  - Make sure db's are empty, otherwise the migration will fail
- Create `.env`, use `.env.example` as template
- Set `DB_DSN` and `TEST_DB_DSN` connection string
  - `DB_DSN` for app db
  - `TEST_DB_DSN` for test db
  - Use pattern `mysqli://{db_username}:{db_password}@{db_host}/{db_name}` for connection string
- Install composer dependencies with command
```shell
composer install
```
- Run migrations with command
```shell
php bin/console migration:migrate --no-interaction
```
- Seed database with command
```shell
php bin/console db:seed
```
- Run demo script
```shell
php index.php
```

## Test
To execute test run the command
```shell
XDEBUG_MODE=coverage php vendor/bin/phpunit
```

See `coverage-report-html` or `coverage-report-xml` for test coverage report
