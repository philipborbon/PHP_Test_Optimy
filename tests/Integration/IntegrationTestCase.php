<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Tests\Integration;

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\ORM\EntityManager;
use Optimy\PhpTestOptimy\App;
use Optimy\PhpTestOptimy\Seeders\DatabaseSeeder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\Container;

abstract class IntegrationTestCase extends TestCase
{
    protected App $app;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Container $container */
        $container = require __DIR__ . '/../../config/container.php';

        $this->app = new App($container);
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /** @var Container $container */
        $container = require __DIR__ . '/../../config/container.php';

        $entityManager = (new App($container))->getContainer()->get(EntityManager::class);

        self::resetMigration($entityManager);

        self::runMigrations($entityManager);

        self::seedTestDb($entityManager);
    }

    private static function resetMigration(EntityManager $entityManager): void
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(true);

        $configurationLoader = new PhpFile(__DIR__ . '/../../config/migrations.php');

        $application->addCommands([
            new Command\MigrateCommand(
                DependencyFactory::fromEntityManager(
                    $configurationLoader,
                    new ExistingEntityManager($entityManager),
                )
            ),
        ]);

        $input = new ArrayInput([
            'command' => 'migrations:migrate',
            'version' => 'first',
            '--no-interaction' => true,
        ]);

        $application->run($input, new BufferedOutput());
    }

    private static function runMigrations(EntityManager $entityManager): void
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(true);

        $configurationLoader = new PhpFile(__DIR__ . '/../../config/migrations.php');

        $application->addCommands([
            new Command\MigrateCommand(
                DependencyFactory::fromEntityManager(
                    $configurationLoader,
                    new ExistingEntityManager($entityManager)
                )
            ),
        ]);

        $input = new ArrayInput([
            'command' => 'migrations:migrate',
            '--no-interaction' => true,
        ]);

        $application->run($input, new BufferedOutput());
    }

    private static function seedTestDb(EntityManager $entityManager): void
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(true);

        $application->addCommands([
            new DatabaseSeeder($entityManager),
        ]);

        $input = new ArrayInput(['command' => 'db:seed']);

        $application->run($input, new BufferedOutput());
    }

    protected function getContainer(): Container
    {
        return $this->app->getContainer();
    }
}
