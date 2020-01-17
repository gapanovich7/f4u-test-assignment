<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Configuration as BaseConfiguration;

final class Configuration
{
    private $configuration;

    public function __construct()
    {
        $this->configuration = Setup::createAnnotationMetadataConfiguration(
            [__DIR__ . '/../../../Domain/'],
            true,
            null,
            null,
            false
        );
    }

    public function getConfiguration(): BaseConfiguration
    {
        return $this->configuration;
    }
}
