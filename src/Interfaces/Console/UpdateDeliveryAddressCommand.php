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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class UpdateDeliveryAddressCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('address-update')
            ->addOption('id', 'i', InputOption::VALUE_REQUIRED)
            ->addOption('country', 'c', InputOption::VALUE_OPTIONAL, 'Country')
            ->addOption('city', 't', InputOption::VALUE_OPTIONAL, 'City')
            ->addOption('street', 's', InputOption::VALUE_OPTIONAL, 'Street')
            ->addOption('zipcode', 'z', InputOption::VALUE_OPTIONAL, 'Zipcode')
            ->addOption('isDefault', 'd', InputOption::VALUE_NONE, 'isDefault');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = EntityManager::create(new Connection(), new Configuration())->getEntityManager();
        $deliveryAddressRepository = new DeliveryAddressRepository($entityManager);

        $data['isDefault'] = $input->getOption('isDefault');

        $this->addFiledToData($input, $data, 'country');
        $this->addFiledToData($input, $data, 'city');
        $this->addFiledToData($input, $data, 'street');

        if (\is_string($input->getOption('zipcode'))) {
            $data['zipcode'] = new DigitString($input->getOption('zipcode'));
        }

        (new DeliveryAddressService())->update($deliveryAddressRepository, $data, (int) $input->getOption('id'));
        $entityManager->flush();

        $output->writeln('Address successful updated!');
    }

    private function addFiledToData(InputInterface $input, array &$data, string $key)
    {
        if (\is_string($input->getOption($key))) {
            $data[$key] = new TextString($input->getOption($key));
        }
    }
}
