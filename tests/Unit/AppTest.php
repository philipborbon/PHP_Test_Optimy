<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Tests\Unit;

use Optimy\PhpTestOptimy\App;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Component\DependencyInjection\Container;

final class AppTest extends UnitTestCase
{
    /**
     * @throws Exception
     */
    public function testGetter(): void
    {
        $container = $this->createMock(Container::class);
        $app = new App($container);

        $this->assertSame($container, $app->getContainer());
    }
}
