<?php

namespace Casisdead2772\PostcodeBundle;

use Casisdead2772\PostcodeBundle\Service\BasePostcodeApiService;

class PostcodeServiceManager
{
    /** @var BasePostcodeApiService[] */
    private array $services;

    /**
     * @param BasePostcodeApiService[] $services
     */
    public function __construct(iterable $services = [])
    {
        $this->services = [];
        foreach ($services as $service) {
            $this->registerService($service);
        }
    }

    public function registerService(BasePostcodeApiService $service): void
    {
        $this->services[$service->getType()] = $service;
    }

    public function findByType(string $type): ?BasePostcodeApiService
    {
        return $this->services[$type] ?? null;
    }

    /**
     * @return BasePostcodeApiService[]
     */
    public function getAvailableExporters(): array
    {
        return $this->services;
    }
}