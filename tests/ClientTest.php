<?php

namespace Isfonzar\tests;

use Isfonzar\TurnstilePhp\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testVerify()
    {
        $mockKey = 's3cr3tk3y';
        $client = new Client($mockKey);

        $input = "cf-turnstile-response";
        $response = $client->verify($input);

        $this->assertTrue($response);
    }
}
