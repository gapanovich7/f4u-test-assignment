<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

final class Connection
{
    private $connection;

    public function __construct()
    {
        $this->connection = [
            'dbname' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'host' => getenv('DB_HOST'),
            'driver' => getenv('DB_DRIVER'),
            'charset' => getenv('DB_CHARSET'),
            'port' => getenv('DB_PORT'),
        ];
    }

    public function getConnection(): array
    {
        return $this->connection;
    }
}
