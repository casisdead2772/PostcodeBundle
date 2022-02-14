<?php

namespace Casisdead2772\PostcodeBundle\Service\PrivateApi\UK;

use Casisdead2772\PostcodeBundle\Models\PostcodeModel;
use Casisdead2772\PostcodeBundle\Service\BaseServices\UK\UKPostcodeBaseService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetAddressApiService extends UKPostcodeBaseService {
    public const BASE_URL = 'https://api.getAddress.io/';

    public function __construct(HttpClientInterface $client, ?string $apiKey) {
        parent::__construct($client);
    }

    public function getAddress(string $postcode, string $apiKey = null): PostcodeModel {
        return new PostcodeModel();
    }

    public function getType() {
        return 'getaddress.io';
    }
}
