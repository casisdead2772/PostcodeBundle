<?php

namespace Casisdead2772\PostcodeBundle\Service;

use Casisdead2772\PostcodeBundle\Models\PostcodeModel;
use stdClass;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class BasePostcodeApiService {
    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    /**
     * @return string
     */
    abstract public function getType(): string;

    /**
     * @param string $postcode
     *
     * @return boolean
     */
    abstract public function validatePostcode(string $postcode): bool;

    /**
     * @param string $postcode
     *
     * @return PostcodeModel
     */
    abstract public function getAddress(string $postcode): PostcodeModel;

    abstract public function getFullInfoByPostcode(string $postcode, ?int $house): stdClass;

    /**
     * @return HttpClientInterface
     */
    final public function getClient(): HttpClientInterface {
        return $this->client;
    }
}
