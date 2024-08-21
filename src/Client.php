<?php

namespace Isfonzar\TurnstilePhp;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    const CHALLENGE_URL = "https://challenges.cloudflare.com/turnstile/v0/siteverify";

    private GuzzleClient $http;

    public function __construct(
        private string $secret,
        ?GuzzleClient $http = null,
    ) {
        $this->http = $http ?? new GuzzleClient();
    }

    public function verify(string $response): bool
    {
        try {
            $result = $this->http->request('POST', self::CHALLENGE_URL, [
                'form_params' => [
                    'secret' => $this->secret,
                    'response' => $response
                ]
            ]);

            $body = $result->getBody();
            $decodedResult = json_decode($body, true);

            return $decodedResult['success'] ?? false;
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Failed to send request: " . $e->getMessage());
        }
    }
}
