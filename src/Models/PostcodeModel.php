<?php

namespace Casisdead2772\PostcodeBundle\Models;

class PostcodeModel {
    /**
     * @var string
     */
    private string $postcode;

    /**
     * @var string
     */
    private string $country;

    /**
     * @var float
     */
    private float $latitude;

    /**
     * @var float
     */
    private float $longitude;

    /**
     * @var string
     */
    private string $city;

    /**
     * @return string
     */
    public function getPostcode(): string {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode(string $postcode): void {
        $this->postcode = $postcode;
    }

    /**
     * @return float
     */
    public function getLatitude(): float {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getCity(): string {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry(): string {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void {
        $this->country = $country;
    }
}
