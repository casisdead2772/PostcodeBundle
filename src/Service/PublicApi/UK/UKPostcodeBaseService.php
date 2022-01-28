<?php

namespace Casisdead2772\PostcodeBundle\Service\PublicApi\UK;

use Casisdead2772\PostcodeBundle\Exceptions\InvalidPostcodeException;
use Casisdead2772\PostcodeBundle\Service\BasePostcodeApiService;

abstract class UKPostcodeBaseService extends BasePostcodeApiService
{
    private const UK_VALID_REGEX = '/^[a-z]{1,2}\d[a-z\d]?\s*\d[a-z]{2}$/i';

    /**
     * @param string $postcode
     * @return bool
     */
    public function validatePostcode(string $postcode): bool
    {
        $validator = preg_match(self::UK_VALID_REGEX, $postcode);
        if($validator === 1){
            return true;
        }

        if ($validator === 0){
            return false;
        }

        throw new \RuntimeException('server error');
    }
}