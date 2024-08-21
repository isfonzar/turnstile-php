<?php

namespace Isfonzar\TurnstilePhp;
class Client
{
    const CHALLENGE_URL = "https://challenges.cloudflare.com/turnstile/v0/siteverify";

    public function __construct(
        private string $secret,
    ) { }

    public function verify(string $response): bool
    {
        return true;
    }
}
