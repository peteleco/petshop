<?php

namespace App\Services\Auth;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;

class JWT
{
    private Configuration $config;

    /**
     * @param non-empty-string $privateKey
     * @param non-empty-string $publicKey
     */
    public function __construct(string $privateKey, string $publicKey, string $passphrase)
    {
        $this->config = Configuration::forAsymmetricSigner(
            new \Lcobucci\JWT\Signer\Rsa\Sha256(),
            InMemory::file($privateKey, $passphrase),
            InMemory::file($publicKey, $passphrase),
        );
    }

    public function issueToken(string $uuid): \Lcobucci\JWT\UnencryptedToken
    {
        $issuedAt = new DateTimeImmutable();
        return $this->config->builder()
            ->issuedBy(config('app.url'))
            ->withClaim('uuid', $uuid)
            ->expiresAt($issuedAt->modify('+1 hour'))
            ->getToken($this->config->signer(), $this->config->signingKey());
    }
}
