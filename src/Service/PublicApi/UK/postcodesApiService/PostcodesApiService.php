<?php

namespace Casisdead2772\PostcodeBundle\Service\PublicApi\UK\postcodesApiService;

use Casisdead2772\PostcodeBundle\Exceptions\InvalidApiServiceException;
use Casisdead2772\PostcodeBundle\Exceptions\InvalidPostcodeException;
use Casisdead2772\PostcodeBundle\Models\PostcodeModel;
use Casisdead2772\PostcodeBundle\Service\PublicApi\UK\UKPostcodeBaseService;

class PostcodesApiService extends UKPostcodeBaseService
{
    private const BASE_URL = 'https://api.postcodes.io/postcodes/';

    /**
     * @param string $postcode
     * @return bool
     * @throws InvalidApiServiceException
     */
    public function validatePostcode(string $postcode): bool {
        try {
            $responce = $this->getClient()->request('GET', 'https://api.postcodes.io/postcodes/'.$postcode.'/validate')->getContent();
        } catch (\Throwable) {
            throw new InvalidApiServiceException('Service not available', 503);
        }

        return json_decode($responce)->result;
    }

    public function getType()
    {
        return 'postcodes.io';
    }

    /**
     * @param string $postcode
     *
     * @return PostcodeModel
     *
     * @throws InvalidApiServiceException
     * @throws InvalidPostcodeException
     */
    public function getAddress(string $postcode): PostcodeModel
    {
        /** @var string $validation */
        $validation = $this->validatePostcode($postcode);

        if($validation) {
            try {
                $response = $this->getClient()->request('GET', self::BASE_URL . $postcode)->getContent();
            } catch (\Throwable) {
                throw new InvalidPostcodeException('Postcode not found');
            }

            $postcodeInfo = json_decode($response)->result;

            $postcodeObj = new PostcodeModel();
            $postcodeObj->setPostcode($postcodeInfo->postcode);
            $postcodeObj->setCountry($postcodeInfo->country);
            $postcodeObj->setCity($postcodeInfo->region);
            $postcodeObj->setLatitude($postcodeInfo->longitude);
            $postcodeObj->setLongitude($postcodeInfo->latitude);

            return $postcodeObj;
        }

        throw new InvalidPostcodeException('Invalid postcode');
    }

    /**
     *
     * @throws InvalidApiServiceException
     * @throws InvalidPostcodeException
     */
    public function getFullInfoByPostcode(string $postcode)
    {
        $validation = $this->validatePostcode($postcode);

        if($validation) {
            try {
                $response = $this->getClient()->request('GET', 'https://api.postcodes.io/postcodes/'.$postcode)->getContent();
            } catch (\Throwable) {
                throw new InvalidApiServiceException('Service not available', 503);
            }

            return json_decode($response);
        }

        throw new InvalidPostcodeException('Invalid postcode');
    }
}