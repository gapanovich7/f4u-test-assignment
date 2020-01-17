<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\ORM\Repository;

use App\Domain\DeliveryAddress\Repository\DeliveryAddressRepositoryInterface;
use App\Domain\DeliveryAddress\Model\DeliveryAddress;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class DeliveryAddressRepository implements DeliveryAddressRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $id
     *
     * @throws NonUniqueResultException
     *
     * @return DeliveryAddress
     */
    public function find(int $id): ?DeliveryAddress
    {
        $qb = $this->entityManager->createQueryBuilder();
        $expr = $qb->expr();

        return $qb
            ->addSelect('da')
            ->from(DeliveryAddress::class, 'da')
            ->andWhere($expr->eq('da.id', ':id'))
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
