<?php

namespace Casisdead2772\PostcodeBundle\Service\PublicApi\UK\getaddressApiService;

use Casisdead2772\PostcodeBundle\Service\PublicApi\UK\UKPostcodeBaseService;

class GetadressApiService extends UKPostcodeBaseService
{
    public function getAddress(string $postcode){
        $responce = $this->getClient()->request('GET', 'https://api.postcodes.io/postcodes/'.$postcode);
        return $responce;
    }

    public function getType()
    {
        return 'getaddress.io';
    }
}