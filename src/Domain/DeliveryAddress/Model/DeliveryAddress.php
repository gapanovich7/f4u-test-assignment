<?php

declare(strict_types=1);

namespace App\Domain\DeliveryAddress\Model;

use App\Domain\Core\Model\DigitString;
use App\Domain\Core\Model\TextString;
use App\Domain\User\Model\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tblDeliveryAddress")
 */
class DeliveryAddress
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\User\Model\User", inversedBy="deliveryAddresses")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string")
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string")
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string")
     */
    private $zipcode;

    /**
     * @var bool
     *
     * @ORM\Column(name="isDefault", type="boolean")
     */
    private $isDefault;

    /**
     * @param User $user
     * @param TextString $country
     * @param TextString $city
     * @param TextString $street
     * @param DigitString $zipcode
     * @param bool $isDefault
     */
    public function __construct(
        User $user,
        TextString $country,
        TextString $city,
        TextString $street,
        DigitString $zipcode,
        bool $isDefault
    ) {
        $this->user = $user;
        $this->country = (string) $country;
        $this->city = (string) $city;
        $this->street = (string) $street;
        $this->zipcode = (string) $zipcode;
        $this->isDefault = $isDefault;

        $user->addDeliveryAddresses($this);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    /**
     * @param array $data
     */
    public function updateFromArray(array $data): void
    {
        if (isset($data['country'])) {
            $this->country = $data['country'];
        }

        if (isset($data['city'])) {
            $this->city = $data['city'];
        }

        if (isset($data['street'])) {
            $this->street = $data['street'];
        }

        if (isset($data['zipcode'])) {
            $this->zipcode = $data['zipcode'];
        }

        if (isset($data['isDefault']) && $data['isDefault']) {
            $this->user->getDefaultDeliveryAddress()->markAsNotDefault();

            $this->isDefault = $data['isDefault'];
        }
    }

    public function markAsNotDefault(): void
    {
        $this->isDefault = false;
    }
}
