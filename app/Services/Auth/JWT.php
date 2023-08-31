<?php

namespace App\Services\Auth;

use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Validation\Constraint\HasClaimWithValue;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JWT
{
    protected Configuration $config;

    protected Request $request;

    protected ?Token $token;

    /**
     * @var \App\Services\Auth\AuthorizationHeader
     */
    private AuthorizationHeader $header;

    private string $issuedBy;

//    private string $privateKey;
//
//    private string $publicKey;
//
//    private string $passphrase;

    protected string $authIdentifierName;

    /**
     * @param non-empty-string $privateKey
     * @param non-empty-string $publicKey
     */
    public function __construct(string $privateKey, string $publicKey, string $passphrase, string $issuedBy, $authIdentifierName = 'uuid', AuthorizationHeader $header = new AuthorizationHeader())
    {

        $this->config = Configuration::forAsymmetricSigner(
            new \Lcobucci\JWT\Signer\Rsa\Sha256(),
            InMemory::file($privateKey, $passphrase),
            InMemory::file($publicKey, $passphrase),
        );

        $this->token = null;
        $this->header = $header;
        $this->issuedBy = $issuedBy;
//        $this->privateKey = $privateKey;
//        $this->publicKey = $publicKey;
//        $this->passphrase = $passphrase;
        $this->authIdentifierName = $authIdentifierName;
    }

    public function issueToken(string $uuid): \Lcobucci\JWT\UnencryptedToken
    {
        $issuedAt = new DateTimeImmutable();

        return $this->config->builder()
            ->issuedBy($this->issuedBy)
            ->withClaim($this->authIdentifierName, $uuid)
            ->expiresAt($issuedAt->modify('+1 hour'))
            ->getToken($this->config->signer(), $this->config->signingKey());
    }

    public function setRequest(Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getToken(): ?Token
    {
        if ($this->token === null) {
            try {
                $this->handleAuthorizationHeader();
            } catch (\Throwable $e) {
                $this->token = null;
            }
        }
        return $this->token;
    }


    /**
     * ---
     * @throws \Throwable
     */
    public function handleAuthorizationHeader(): void
    {
        $headerToken = $this->header->token($this->request);

        $token = $this->config->parser()->parse($headerToken);

        // Has Uuid  validation
        throw_if(
            !$token->claims()->has($this->authIdentifierName),
            UnauthorizedHttpException::class,
            __('Invalid token. #01')
        );

        // Expired validation
        throw_if(
            $token->isExpired(Carbon::now()),
            UnauthorizedHttpException::class,
            __('Invalid token. #02')
        );

        // Issued By validation
        throw_if(
            ! $this->config->validator()->validate($token, new IssuedBy($this->issuedBy)),
            UnauthorizedHttpException::class,
            __('Invalid token. #03')
        );
        // Signature validation
        throw_if(
            ! $this->config->validator()->validate(
                $token,
                new SignedWith($this->config->signer(), $this->config->verificationKey())
            ),
            UnauthorizedHttpException::class,
            __('Invalid token. #04')
        );
        $this->token = $token;
    }

    public function getAuthIdentifierName(): string
    {
        return $this->authIdentifierName;
    }
}
