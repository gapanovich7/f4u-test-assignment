<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager as BaseEntityManager;

final class EntityManager
{
    private $connection;
    private $configuration;

    private function __construct(Connection $connection, Configuration $configuration)
    {
        $this->connection = $connection;
        $this->configuration = $configuration;
    }

    public static function create(Connection $connection, Configuration $configuration): self
    {
        return new self($connection, $configuration);
    }

    public function getEntityManager(): BaseEntityManager
    {
        return BaseEntityManager::create($this->connection->getConnection(), $this->configuration->getConfiguration());
    }
}
