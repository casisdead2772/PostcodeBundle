<?php

namespace Casisdead2772\PostcodeBundle\Service\PrivateApi;

interface PostcodePrivateApiInterface
{
    public function getAddress(string $postcode, string $apiKey);
}