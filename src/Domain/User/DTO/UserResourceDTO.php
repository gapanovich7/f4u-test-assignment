<?php

declare(strict_types=1);

namespace App\Domain\User\DTO;

use App\Domain\DeliveryAddress\DTO\DeliveryAddressCollectionDTO;
use App\Domain\User\Model\User;

final class UserResourceDTO implements \JsonSerializable
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function jsonSerialize(): array
    {
        return [
            'firstName' => $this->user->getFirstName(),
            'lastName' => $this->user->getLastName(),
            'deliveryAddresses' => new DeliveryAddressCollectionDTO($this->user->getDeliveryAddresses()),
        ];
    }

    public function __toString(): string
    {
        return (string) \json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}
