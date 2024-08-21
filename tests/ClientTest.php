<?php

namespace Isfonzar\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Isfonzar\TurnstilePhp\Client;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ClientTest extends TestCase
{
    private GuzzleClient $guzzleMock;
    private Client $client;

    protected function setUp(): void
    {
        $this->guzzleMock = $this->createMock(GuzzleClient::class);
        $this->client = new Client('s3cr3tk3y', $this->guzzleMock);
    }

    #[DataProvider('responseProvider')]
    public function testVerify(bool $expectedSuccess, bool $apiResponse)
    {
        $responseMock = new Response(200, [], json_encode(['success' => $apiResponse]));

        $this->guzzleMock->method('request')
            ->willReturn($responseMock);

        $input = "cf-turnstile-response";
        $response = $this->client->verify($input);

        $this->assertEquals($expectedSuccess, $response);
    }

    public static function responseProvider(): array
    {
        return [
            [true, true],  // Test case where API returns success true
            [false, false] // Test case where API returns success false
        ];
    }
}
