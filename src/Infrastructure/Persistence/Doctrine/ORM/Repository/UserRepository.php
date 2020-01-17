<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\ORM\Repository;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class UserRepository implements UserRepositoryInterface
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
     * @return User
     */
    public function find(int $id): ?User
    {
        $qb = $this->entityManager->createQueryBuilder();
        $expr = $qb->expr();

        return $qb
            ->addSelect('u')
            ->from(User::class, 'u')
            ->andWhere($expr->eq('u.id', ':id'))
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
