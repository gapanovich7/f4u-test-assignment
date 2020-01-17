<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use App\Domain\DeliveryAddress\Model\DeliveryAddress;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tblUser")
 */
class User
{
    public const MAX_DELIVERY_ADDRESSES_COUNT = 3;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Collection<DeliveryAddress>
     *
     * @ORM\OneToMany(targetEntity="App\Domain\DeliveryAddress\Model\DeliveryAddress", mappedBy="user")
     */
    private $deliveryAddresses;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string")
     */
    private $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->deliveryAddresses = new ArrayCollection();
    }

    /**
     * @return Collection<DeliveryAddress>
     */
    public function getDeliveryAddresses(): Collection
    {
        return $this->deliveryAddresses;
    }

    /**
     * @return DeliveryAddress|null
     */
    public function getDefaultDeliveryAddress(): ?DeliveryAddress
    {
        foreach ($this->deliveryAddresses as $deliveryAddress) {
            if ($deliveryAddress->isDefault()) {
                return $deliveryAddress;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function haveDeliveryAddress(): bool
    {
        return $this->deliveryAddresses->count() > 0;
    }

    /**
     * @return bool
     */
    public function isMaxDeliveryAddressesCount(): bool
    {
        return self::MAX_DELIVERY_ADDRESSES_COUNT === $this->deliveryAddresses->count();
    }

    /**
     * @param DeliveryAddress $deliveryAddress
     */
    public function addDeliveryAddresses(DeliveryAddress $deliveryAddress): void
    {
        $this->deliveryAddresses->add($deliveryAddress);
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
}
