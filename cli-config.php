<?php

declare(strict_types=1);

use App\Infrastructure\Persistence\Doctrine\Configuration;
use App\Infrastructure\Persistence\Doctrine\Connection;
use App\Infrastructure\Persistence\Doctrine\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env', __DIR__ . '/.env.local');

$entityManager = EntityManager::create(new Connection(), new Configuration())->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
