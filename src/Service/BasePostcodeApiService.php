<?php

namespace Casisdead2772\PostcodeBundle\Service;

use Casisdead2772\PostcodeBundle\Models\PostcodeModel;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class BasePostcodeApiService {
    /**
     * @param string $postcode
     *
     * @return mixed
     */
    abstract public function validatePostcode(string $postcode): bool;

    abstract public function getAddress(string $postcode): PostcodeModel;

    abstract public function getType();

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    /**
     * @return HttpClientInterface
     */
    final public function getClient(): HttpClientInterface {
        return $this->client;
    }
}
