<?php

namespace Casisdead2772\PostcodeBundle\tests\Service\PublicApi\UK\postcodesApiService;

use Casisdead2772\PostcodeBundle\Service\PublicApi\UK\postcodesApiService\PostcodesApiService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpClient\MockHttpClient;

class PostcodesApiServiceTest extends TestCase {
    public function testGetAddress() {
        $responses = [
            new MockResponse(json_encode([
                'result' => 'true'
            ], JSON_THROW_ON_ERROR)),
            new MockResponse(json_encode([
                'result' => [
                    'postcode' => 'testPostcode',
                    'country' => 'test',
                    'region' => 'test',
                    'longitude' => 123123123,
                    'latitude' => 123123.123,
                ]
            ], JSON_THROW_ON_ERROR))
        ];

        $client = new MockHttpClient($responses);
        $postcodeService = new PostcodesApiService($client);
        $result = $postcodeService->getAddress('aaa aaa');

        self::assertEquals('testPostcode', $result->getPostcode());
    }
}
