<?php

namespace Casisdead2772\PostcodeBundle\Service\PublicApi\UK\postcodesApiService;

use Casisdead2772\PostcodeBundle\Exceptions\InvalidApiServiceException;
use Casisdead2772\PostcodeBundle\Exceptions\InvalidPostcodeException;
use Casisdead2772\PostcodeBundle\Models\PostcodeModel;
use Casisdead2772\PostcodeBundle\Service\BaseServices\UK\UKPostcodeBaseService;
use stdClass;

class PostcodesApiService extends UKPostcodeBaseService {
    public const BASE_URL = 'https://api.postcodes.io/postcodes/';

    /**
     * @return string
     */
    public function getType(): string {
        return 'postcodes.io';
    }

    /**
     * @param string $postcode
     *
     * @return bool
     *
     * @throws InvalidApiServiceException
     * @throws \JsonException
     */
    public function validatePostcode(string $postcode): bool {
        try {
            $response = $this->getClient()->request('GET', self::BASE_URL.$postcode.'/validate')->getContent();
        } catch (\Throwable $e) {
            throw new InvalidApiServiceException($e->getMessage());
        }

        return json_decode($response, false, 512, JSON_THROW_ON_ERROR)->result;
    }

    /**
     * @param string $postcode
     *
     * @return PostcodeModel
     *
     * @throws InvalidApiServiceException
     * @throws InvalidPostcodeException
     * @throws \JsonException
     */
    public function getAddress(string $postcode): PostcodeModel {
        /** @var string $validation */
        $validation = $this->validatePostcode($postcode);

        if ($validation) {
            try {
                $response = $this->getClient()->request('GET', self::BASE_URL.$postcode)->getContent();
            } catch (\Throwable $e) {
                throw new InvalidPostcodeException($e->getMessage());
            }

            $postcodeInfo = json_decode($response, false, 512, JSON_THROW_ON_ERROR)->result;

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
     * @param string $postcode
     * @param int|null $house
     *
     * @return stdClass
     *
     * @throws InvalidApiServiceException
     * @throws InvalidPostcodeException
     * @throws \JsonException
     */
    public function getFullInfoByPostcode(string $postcode, int $house = null): stdClass {
        $validation = $this->validatePostcode($postcode);

        if ($validation) {
            try {
                $response = $this->getClient()->request('GET', self::BASE_URL.$postcode)->getContent();
            } catch (\Throwable) {
                throw new InvalidApiServiceException('Service not available', 503);
            }

            return json_decode($response, false, 512, JSON_THROW_ON_ERROR);
        }

        throw new InvalidPostcodeException('Invalid postcode');
    }
}
