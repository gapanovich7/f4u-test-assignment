<?php

declare(strict_types=1);

namespace Tests\Domain\DeliveryAddress\Service;

use App\Application\Exception\MaxDeliveryAddressesCountException;
use App\Application\Exception\NotFoundEntityException;
use App\Application\Exception\RemoveDefaultDeliveryAddressesException;
use App\Domain\Core\Model\DigitString;
use App\Domain\Core\Model\TextString;
use App\Domain\DeliveryAddress\Model\DeliveryAddress;
use App\Domain\DeliveryAddress\Service\DeliveryAddressService;
use App\Domain\User\Model\User;
use App\Infrastructure\Persistence\Doctrine\ORM\Repository\DeliveryAddressRepository;
use App\Infrastructure\Persistence\Doctrine\ORM\Repository\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeliveryAddressServiceTest extends TestCase
{
    private const DELIVERY_ADDRESS_ID = 1;

    private $deliveryAddressService;

    /**
     * @var UserRepository|MockObject
     */
    private $userRepository;

    /**
     * @var DeliveryAddressRepository|MockObject
     */
    private $deliveryAddressRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->deliveryAddressRepository = $this->createMock(DeliveryAddressRepository::class);
        $this->deliveryAddressService = new DeliveryAddressService();
    }

    public function testCreate(): void
    {
        $user = new User('FirstName', 'LastName');

        $this->userRepository
            ->expects($this->once())
            ->method('find')
            ->with(self::DELIVERY_ADDRESS_ID)
            ->willReturn($user);

        $deliveryAddress = $this->deliveryAddressService->create(
            $this->userRepository,
            new TextString('Country'),
            new TextString('City'),
            new TextString('Street'),
            new DigitString('010101'),
            self::DELIVERY_ADDRESS_ID
        );

        $this->assertInstanceOf(DeliveryAddress::class, $deliveryAddress);
    }

    public function testCreateThrowExceptionForNotFoundUser(): void
    {

        $this->userRepository
            ->expects($this->once())
            ->method('find')
            ->with(self::DELIVERY_ADDRESS_ID)
            ->willReturn(null);

        $this->expectException(NotFoundEntityException::class);

        $this->deliveryAddressService->create(
            $this->userRepository,
            new TextString('Country'),
            new TextString('City'),
            new TextString('Street'),
            new DigitString('010101'),
            self::DELIVERY_ADDRESS_ID
        );
    }

    public function testCreateThrowExceptionForMaxDeliveryAddressesCount(): void
    {
        $user = new User('FirstName', 'LastName');

        for ($i = 0; $i < User::MAX_DELIVERY_ADDRESSES_COUNT; ++$i) {
            new DeliveryAddress(
                $user,
                new TextString('Country'),
                new TextString('City'),
                new TextString('Street'),
                new DigitString('010101'),
                false
            );
        }

        $this->userRepository
            ->expects($this->once())
            ->method('find')
            ->with(self::DELIVERY_ADDRESS_ID)
            ->willReturn($user);

        $this->expectException(MaxDeliveryAddressesCountException::class);

        $this->deliveryAddressService->create(
            $this->userRepository,
            new TextString('Country'),
            new TextString('City'),
            new TextString('Street'),
            new DigitString('010101'),
            1
        );
    }

    public function testUpdate(): void
    {

        $user = new User('FirstName', 'LastName');
        $deliveryAddress = new DeliveryAddress(
            $user,
            new TextString('Country'),
            new TextString('City'),
            new TextString('Street'),
            new DigitString('010101'),
            false
        );

        $data['isDefault'] = false;

        $this->deliveryAddressRepository
            ->expects($this->once())
            ->method('find')
            ->with(self::DELIVERY_ADDRESS_ID)
            ->willReturn($deliveryAddress);

        $this->deliveryAddressService->update($this->deliveryAddressRepository, $data, self::DELIVERY_ADDRESS_ID);
    }

    public function testUpdateThrowExceptionForNotFoundUser(): void
    {

        $this->deliveryAddressRepository
            ->expects($this->once())
            ->method('find')
            ->with(self::DELIVERY_ADDRESS_ID)
            ->willReturn(null);

        $this->expectException(NotFoundEntityException::class);
        $this->deliveryAddressService->update($this->deliveryAddressRepository, [], self::DELIVERY_ADDRESS_ID);
    }

    public function testRemove(): void
    {

        $user = new User('FirstName', 'LastName');
        $deliveryAddress = new DeliveryAddress(
            $user,
            new TextString('Country'),
            new TextString('City'),
            new TextString('Street'),
            new DigitString('010101'),
            false
        );

        $this->deliveryAddressRepository
            ->expects($this->once())
            ->method('find')
            ->with(self::DELIVERY_ADDRESS_ID)
            ->willReturn($deliveryAddress);

        $deliveryAddress = $this->deliveryAddressService->remove($this->deliveryAddressRepository, self::DELIVERY_ADDRESS_ID);
        $this->assertInstanceOf(DeliveryAddress::class, $deliveryAddress);
    }

    public function testRemoveThrowExceptionForNotFoundUser(): void
    {

        $this->deliveryAddressRepository
            ->expects($this->once())
            ->method('find')
            ->with(self::DELIVERY_ADDRESS_ID)
            ->willReturn(null);

        $this->expectException(NotFoundEntityException::class);
        $this->deliveryAddressService->remove($this->deliveryAddressRepository, self::DELIVERY_ADDRESS_ID);
    }

    public function testRemoveThrowExceptionForRemoveDefaultDeliveryAddressesException(): void
    {

        $user = new User('FirstName', 'LastName');
        $deliveryAddress = new DeliveryAddress(
            $user,
            new TextString('Country'),
            new TextString('City'),
            new TextString('Street'),
            new DigitString('010101'),
            true
        );

        $this->deliveryAddressRepository
            ->expects($this->once())
            ->method('find')
            ->with(self::DELIVERY_ADDRESS_ID)
            ->willReturn($deliveryAddress);

        $this->expectException(RemoveDefaultDeliveryAddressesException::class);
        $this->deliveryAddressService->remove($this->deliveryAddressRepository, self::DELIVERY_ADDRESS_ID);
    }
}