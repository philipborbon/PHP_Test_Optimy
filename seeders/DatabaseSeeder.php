<?php

declare(strict_types=1);

namespace Optimy\PhpTestOptimy\Seeders;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'db:seed')]
final class DatabaseSeeder extends Command
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setDescription('Seed database with initial data. !WARNING: THIS WILL REPLACE ANY EXISTING DATA WITH SEED DATA.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loader = new Loader();
        $this->loadFixtures($loader);

        $executor = new OrmExecutor($this->entityManager, new ORMPurger());
        $executor->execute($loader->getFixtures());

        $output->writeln('Database has been seeded successfully.');

        return Command::SUCCESS;
    }

    private function loadFixtures(Loader $loader): void
    {
        $loader->addFixture(new NewsSeeder());
    }
}
