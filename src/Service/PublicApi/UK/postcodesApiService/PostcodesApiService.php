<?php

namespace Casisdead2772\PostcodeBundle\Service\PublicApi\UK\postcodesApiService;

use Casisdead2772\PostcodeBundle\Exceptions\InvalidApiServiceException;
use Casisdead2772\PostcodeBundle\Exceptions\InvalidPostcodeException;
use Casisdead2772\PostcodeBundle\Models\PostcodeModel;
use Casisdead2772\PostcodeBundle\Service\PublicApi\PostcodePublicApiInterface;
use Casisdead2772\PostcodeBundle\Service\PublicApi\UK\UKPostcodeBaseService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;


class PostcodesApiService extends UKPostcodeBaseService implements PostcodePublicApiInterface
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
        } catch (Throwable) {
            throw new InvalidApiServiceException('Service not available', 503);
        }

        return json_decode($responce)->status;
    }

    public function getBaseURL()
    {
        return self::BASE_URL;
    }

    /**
     * @param string $postcode
     *
     * @return array|PostcodeModel
     *
     * @throws InvalidApiServiceException
     * @throws InvalidPostcodeException
     */
    public function getAddress(string $postcode){
        /** @var string $validation */
        $validation = $this->validatePostcode($postcode);

        if($validation) {
            try {
                $response = $this->getClient()->request('GET', self::BASE_URL . $postcode)->getContent();
            } catch (Throwable $exception) {
                return (['message' => $exception->getMessage(), 'code' => $exception->getCode()]);
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
            } catch (Throwable) {
                throw new InvalidApiServiceException('Service not available', 503);
            }

            return json_decode($response);
        }

        throw new InvalidPostcodeException('Invalid postcode');
    }
}