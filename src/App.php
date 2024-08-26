<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy;

use Symfony\Component\DependencyInjection\Container;

final class App
{
    public function __construct(private readonly Container $container)
    {
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}
