<?php

declare(strict_types=1);

namespace App\Interfaces\Console;

use App\Domain\Core\Model\DigitString;
use App\Domain\Core\Model\TextString;
use App\Domain\DeliveryAddress\Service\DeliveryAddressService;
use App\Infrastructure\Persistence\Doctrine\Configuration;
use App\Infrastructure\Persistence\Doctrine\Connection;
use App\Infrastructure\Persistence\Doctrine\EntityManager;
use App\Infrastructure\Persistence\Doctrine\ORM\Repository\DeliveryAddressRepository;
use App\Infrastructure\Persistence\Doctrine\ORM\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

final class CreateDeliveryAddressCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('address-create')
            ->addOption('id', 'i', InputOption::VALUE_REQUIRED)
            ->addOption('country', 'c', InputOption::VALUE_REQUIRED, 'Country')
            ->addOption('city', 't', InputOption::VALUE_REQUIRED, 'City')
            ->addOption('street', 's', InputOption::VALUE_REQUIRED, 'Street')
            ->addOption('zipcode', 'z', InputOption::VALUE_REQUIRED, 'Zipcode');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = EntityManager::create(new Connection(), new Configuration())->getEntityManager();

        $userRepository = new UserRepository($entityManager);

        $country = new TextString($input->getOption('country'));
        $city = new TextString($input->getOption('city'));
        $street = new TextString($input->getOption('street'));
        $zipcode = new DigitString($input->getOption('zipcode'));

        $deliveryAddress = (new DeliveryAddressService())->create(
            $userRepository,
            $country,
            $city,
            $street,
            $zipcode,
            (int) $input->getOption('id')
        );

        $entityManager->persist($deliveryAddress);
        $entityManager->flush();

        $output->writeln('Address successful created!');
    }
}
