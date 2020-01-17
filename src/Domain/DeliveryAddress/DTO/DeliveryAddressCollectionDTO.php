<?php

declare(strict_types=1);

namespace App\Domain\DeliveryAddress\DTO;

use App\Domain\DeliveryAddress\Model\DeliveryAddress;
use Doctrine\Common\Collections\Collection;

final class DeliveryAddressCollectionDTO implements \JsonSerializable
{
    /**
     * @var Collection<DeliveryAddress>
     */
    private $deliveryAddresses;

    /**
     * @param Collection<DeliveryAddress> $deliveryAddresses
     */
    public function __construct(Collection $deliveryAddresses)
    {
        $this->deliveryAddresses = $deliveryAddresses;
    }

    public function jsonSerialize(): array
    {
        return $this->deliveryAddresses
            ->map(
                static function (DeliveryAddress $deliveryAddress) {
                    return [
                        'id' => $deliveryAddress->getId(),
                        'country' => $deliveryAddress->getCountry(),
                        'city' => $deliveryAddress->getCity(),
                        'street' => $deliveryAddress->getStreet(),
                        'zipcode' => $deliveryAddress->getZipcode(),
                        'isDefault' => $deliveryAddress->isDefault(),
                    ];
                }
            )
            ->toArray();
    }

    public function __toString(): string
    {
        return (string) \json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}
