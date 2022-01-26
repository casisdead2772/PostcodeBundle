<?php

namespace Casisdead2772\PostcodeBundle\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class BasePostcodeApiService
{
    abstract public function validatePostcode(string $postcode);

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return HttpClientInterface
     */
    final public function getClient(): HttpClientInterface
    {
        return $this->client;
    }
}