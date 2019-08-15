<?php


namespace PonyCool\Core\Jwt\Signature;


interface  AlgInterface
{
    public function init(string $secret, array $header, array $payload): void;

    public function encrypt(): string;

    public function decrypt(): array;
}