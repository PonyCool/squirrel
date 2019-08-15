<?php


namespace PonyCool\Core\Jwt\Signature;


class Hs256
{
    public function encrypt(string $secret, string $raw): string
    {
        $signature = hash_hmac("SHA256", $raw, $secret, true);
        return $signature;
    }

    public function decrypt()
    {
        // TODO: Implement decrypt() method.
    }
}