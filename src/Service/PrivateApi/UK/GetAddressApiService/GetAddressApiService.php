<?php

namespace Casisdead2772\PostcodeBundle\Service\PrivateApi\UK;

use Casisdead2772\PostcodeBundle\Exceptions\InvalidApiServiceException;
use Casisdead2772\PostcodeBundle\Exceptions\InvalidPostcodeException;
use Casisdead2772\PostcodeBundle\Models\PostcodeModel;
use Casisdead2772\PostcodeBundle\Service\BaseServices\UK\UKPostcodeBaseService;
use stdClass;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetAddressApiService extends UKPostcodeBaseService {
    public const BASE_URL = 'https://api.getAddress.io/find/';

    /**
     * @var string
     */
    private string $apiKey;

    /**
     * GetAddressApiService constructor.
     *
     * @param HttpClientInterface $client
     * @param string $apiKey
     */
    public function __construct(HttpClientInterface $client, string $apiKey) {
        parent::__construct($client);
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getType(): string {
        return 'getaddress.io';
    }

    /**
     * @param string $postcode
     *
     * @return PostcodeModel
     *
     * @throws InvalidApiServiceException
     * @throws InvalidPostcodeException
     */
    public function getAddress(string $postcode): PostcodeModel {
        /** @var string $validation */
        $validation = $this->validatePostcode($postcode);

        if ($validation) {
            try {
                $response = $this->getClient()->request('GET', self::BASE_URL.$postcode.'/?api-key='.$this->apiKey.'&expand=true')->getContent();
                $addresses = json_decode($response, false, 512, JSON_THROW_ON_ERROR);
            } catch (\Throwable $e) {
                throw new InvalidApiServiceException($e->getMessage());
            }

            $postcodeObj = new PostcodeModel();
            $postcodeObj->setPostcode($addresses->postcode);
            $postcodeObj->setCountry($addresses->adresses[0]->country);
            $postcodeObj->setCity($addresses->adresses[0]->town_or_city);
            $postcodeObj->setLatitude($addresses->longitude);
            $postcodeObj->setLongitude($addresses->latitude);

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
     */
    public function getFullInfoByPostcode(string $postcode, ?int $house): stdClass {
        $validation = $this->validatePostcode($postcode);

        $houseNumber = $house ? '/'.$house : null;

        if ($validation) {
            try {
                $response = $this->getClient()->request('GET', self::BASE_URL.$postcode.$houseNumber.'/?api-key='.$this->apiKey.'&expand=true')->getContent();
                $addresses = json_decode($response, false, 512, JSON_THROW_ON_ERROR);
            } catch (\Throwable $e) {
                throw new InvalidApiServiceException($e->getMessage());
            }

            return $addresses;
        }

        throw new InvalidPostcodeException('Invalid postcode');
    }
}
