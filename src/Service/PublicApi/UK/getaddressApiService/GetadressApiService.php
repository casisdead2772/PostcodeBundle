<?php

namespace Casisdead2772\PostcodeBundle\Service\PublicApi\UK\getaddressApiService;

use Casisdead2772\PostcodeBundle\Service\PublicApi\PostcodePublicApiInterface;
use Casisdead2772\PostcodeBundle\Service\PublicApi\UK\UKPostcodeBaseService;


class GetadressApiService extends UKPostcodeBaseService implements PostcodePublicApiInterface
{
    public function getAddress(string $postcode, string $apiKey = ''){
        $responce = $this->getClient()->request('GET', 'https://api.postcodes.io/postcodes/'.$postcode);
        return $responce;
    }

    public function getBaseURL()
    {
        // TODO: Implement getBaseURL() method.
    }
}