<?php

namespace App\Services\Auth;

use Carbon\Carbon;
use DateTimeImmutable;
use Lcobucci\JWT\Token;
use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JWT
{
    protected Configuration $config;

    protected Request $request;

    protected Token|null $token = null;

    protected AuthorizationHeader $header;

    /**
     * @var non-empty-string
     */
    protected string $issuedBy;

    /**
     * @var non-empty-string
     */
    protected string $authIdentifierName;

    /**
     * @param non-empty-string $privateKey
     * @param non-empty-string $publicKey
     * @param non-empty-string $issuedBy
     * @param non-empty-string $authIdentifierName
     */
    public function __construct(string $privateKey, string $publicKey, string $passphrase, string $issuedBy, string $authIdentifierName = 'uuid', AuthorizationHeader $header = new AuthorizationHeader())
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
        throw_if(
            !$headerToken,
            UnauthorizedHttpException::class,
            __('Invalid token. #01')
        );

        $token = $this->config->parser()->parse($headerToken);

        // ValidateUuid
        $this->validateUuid($token, $this->authIdentifierName);

        // Expired validation
        throw_if(
            $token->isExpired(Carbon::now()),
            UnauthorizedHttpException::class,
            __('Invalid token. #03')
        );

        // Issued By validation
        throw_if(
            ! $this->config->validator()->validate($token, new IssuedBy($this->issuedBy)),
            UnauthorizedHttpException::class,
            __('Invalid token. #04')
        );
        // Signature validation
        throw_if(
            ! $this->config->validator()->validate(
                $token,
                new SignedWith($this->config->signer(), $this->config->verificationKey())
            ),
            UnauthorizedHttpException::class,
            __('Invalid token. #05')
        );
        $this->token = $token;
    }

    public function getAuthIdentifierName(): string
    {
        return $this->authIdentifierName;
    }

    /**
     * @param non-empty-string $authIdentifierName
     *
     * @throws \Throwable
     */
    public function validateUuid(Token $token, string $authIdentifierName): void
    {
        throw_if(
            $token instanceof \Lcobucci\JWT\Token\Plain === false,
            UnauthorizedHttpException::class,
            __('Invalid token. #02')
        );
        throw_if(
            !$token->claims()->has($authIdentifierName),
            UnauthorizedHttpException::class,
            __('Invalid token. #02')
        );
    }
}
