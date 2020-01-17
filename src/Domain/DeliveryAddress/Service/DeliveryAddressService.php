<?php

declare(strict_types=1);

namespace App\Domain\DeliveryAddress\Service;

use App\Domain\Core\Model\ValueObjectInterface;
use App\Domain\DeliveryAddress\Repository\DeliveryAddressRepositoryInterface;
use App\Domain\DeliveryAddress\Model\DeliveryAddress;
use App\Domain\User\Model\User;
use App\Application\Exception\MaxDeliveryAddressesCountException;
use App\Application\Exception\NotFoundEntityException;
use App\Application\Exception\RemoveDefaultDeliveryAddressesException;
use App\Domain\Core\Model\DigitString;
use App\Domain\Core\Model\TextString;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;

final class DeliveryAddressService
{
    public function create(
        UserRepositoryInterface $userRepository,
        TextString $country,
        TextString $city,
        TextString $street,
        DigitString $zipcode,
        int $id
    ): DeliveryAddress {
        $user = $userRepository->find($id);

        if (!$user instanceof User) {
            throw new NotFoundEntityException(
                \sprintf('User with id %s not found', $id)
            );
        }

        if ($user->isMaxDeliveryAddressesCount()) {
            throw new MaxDeliveryAddressesCountException(
                \sprintf('User with id %s have max delivery addresses', $id)
            );
        }

        return new DeliveryAddress($user, $country, $city, $street, $zipcode, !$user->haveDeliveryAddress());
    }

    /**
     * @param DeliveryAddressRepositoryInterface $deliveryAddressRepository
     * @param ValueObjectInterface[] $data
     * @param int $id
     *
     * @throws NotFoundEntityException
     * @throws NonUniqueResultException
     */
    public function update(DeliveryAddressRepositoryInterface $deliveryAddressRepository, array $data, int $id): void
    {
        $deliveryAddress = $deliveryAddressRepository->find($id);

        if (!$deliveryAddress instanceof DeliveryAddress) {
            throw new NotFoundEntityException(
                \sprintf('Delivery address with id %s not found', $id)
            );
        }

        $deliveryAddress->updateFromArray($data);
    }

    public function remove(DeliveryAddressRepositoryInterface $deliveryAddressRepository, int $id): DeliveryAddress
    {
        $deliveryAddress = $deliveryAddressRepository->find($id);

        if (!$deliveryAddress instanceof DeliveryAddress) {
            throw new NotFoundEntityException(
                \sprintf('Delivery address with id %s not found', $id)
            );
        }

        if ($deliveryAddress->isDefault()) {
            throw new RemoveDefaultDeliveryAddressesException(
                \sprintf('Delivery address with id %s can`t be removed', $id)
            );
        }

        return $deliveryAddress;
    }
}
