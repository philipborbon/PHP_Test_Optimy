<?php

declare(strict_types=1);

use Optimy\PhpTestOptimy\App;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

(new Dotenv())->loadEnv(__DIR__ . '/.env');

$container = require __DIR__ . '/config/container.php';

$app = new App($container);

return $app;
