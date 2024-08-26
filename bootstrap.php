<?php

use Symfony\Component\Dotenv\Dotenv;

require 'vendor/autoload.php';

(new Dotenv())->loadEnv(__DIR__.'/.env');
