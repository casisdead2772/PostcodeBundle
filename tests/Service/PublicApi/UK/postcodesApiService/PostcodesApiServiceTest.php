<?php

namespace Casisdead2772\PostcodeBundle\tests\Service\PublicApi\UK\postcodesApiService;

use Casisdead2772\PostcodeBundle\Models\PostcodeModel;
use Casisdead2772\PostcodeBundle\Service\PublicApi\UK\postcodesApiService\PostcodesApiService;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PostcodesApiServiceTest extends TestCase {
    /**
     * @var HttpClientInterface|MockObject
     */
    private HttpClientInterface|MockObject $client;

    /**
     * @var PostcodesApiService
     */
    private PostcodesApiService $postcodeService;

    public function setUp(): void {
        $this->client = $this->createMock(HttpClientInterface::class);
        $this->postcodeService = new PostcodesApiService($this->client);
    }

    public function testValidatePostcode()
    {
        $matcher = $this->exactly(2);

        $responce = $this->createMock(ResponseInterface::class);

        $responce->expects($matcher)
            ->method('getContent')
            ->willReturnCallback(function () use ($matcher) {
                if($matcher->getInvocationCount() === 1) {
                    return json_encode([
                        'result' => 'true'
                    ], JSON_THROW_ON_ERROR);
                }

                return json_encode([
                    'result' => [
                        'postcode' => 'testPostcode',
                        'country' => 'test',
                        'region' => 'test',
                        'longitude' => 123123123,
                        'latitude' => 123123.123,
                    ]
                ], JSON_THROW_ON_ERROR);
            });


        $this->client->expects($this->atLeastOnce())
            ->method('request')
            ->willReturn($responce);



        $result = $this->postcodeService->getAddress('aaa aaa');

        self::assertIsObject($result);
    }
}
