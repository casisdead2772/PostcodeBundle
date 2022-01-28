<?php


namespace Casisdead2772\PostcodeBundle\Service\PublicApi;

interface PostcodePublicApiInterface
{
    public function getAddress(string $postcode);
}