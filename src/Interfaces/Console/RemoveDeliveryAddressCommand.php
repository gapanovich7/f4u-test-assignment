<?php

declare(strict_types=1);

namespace App\Interfaces\Console;

use App\Domain\DeliveryAddress\Service\DeliveryAddressService;
use App\Infrastructure\Persistence\Doctrine\Configuration;
use App\Infrastructure\Persistence\Doctrine\Connection;
use App\Infrastructure\Persistence\Doctrine\EntityManager;
use App\Infrastructure\Persistence\Doctrine\ORM\Repository\DeliveryAddressRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class RemoveDeliveryAddressCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('address-remove')
            ->addOption('id', 'i', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = EntityManager::create(new Connection(), new Configuration())->getEntityManager();
        $deliveryAddressRepository = new DeliveryAddressRepository($entityManager);
        $deliveryAddress = (new DeliveryAddressService())->remove(
            $deliveryAddressRepository,
            (int) $input->getOption('id')
        );

        $entityManager->remove($deliveryAddress);
        $entityManager->flush();

        $output->writeln('Address successful removed!');
    }
}
