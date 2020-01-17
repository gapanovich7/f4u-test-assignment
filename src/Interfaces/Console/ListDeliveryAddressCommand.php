<?php

declare(strict_types=1);

namespace App\Interfaces\Console;

use App\Domain\User\DTO\UserResourceDTO;
use App\Domain\User\Model\User;
use App\Application\Exception\NotFoundEntityException;
use App\Infrastructure\Persistence\Doctrine\Configuration;
use App\Infrastructure\Persistence\Doctrine\Connection;
use App\Infrastructure\Persistence\Doctrine\EntityManager;
use App\Infrastructure\Persistence\Doctrine\ORM\Repository\DeliveryAddressRepository;
use App\Infrastructure\Persistence\Doctrine\ORM\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ListDeliveryAddressCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('address-list')
            ->addOption('id', 'i', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = EntityManager::create(new Connection(), new Configuration())->getEntityManager();

        $user = (new UserRepository($entityManager))->find((int) $input->getOption('id'));

        if (!$user instanceof User) {
            throw new NotFoundEntityException(
                \sprintf('User with id %s not found', $input->getOption('id'))
            );
        }

        $output->writeln(new UserResourceDTO($user));
    }
}
