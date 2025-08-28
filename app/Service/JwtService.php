<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Service;

use DateTimeImmutable;
use Exception;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use function Hyperf\Support\env;

class JwtService
{
    private Configuration $config;

    private string $secretKey;

    public function __construct()
    {
        $this->secretKey = env('JWT_SECRET', 'your-secret-key-change-this-in-production');

        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->secretKey)
        );

        // Add validation constraints
        $this->config->setValidationConstraints(
            new SignedWith($this->config->signer(), $this->config->signingKey()),
            new StrictValidAt(SystemClock::fromSystemTimezone()),
        );
    }

    /**
     * Generate JWT token.
     */
    public function generateToken(array $payload, int $expiresInMinutes = 60): string
    {
        $now = new DateTimeImmutable();
        $expiresAt = $now->modify("+{$expiresInMinutes} minutes");

        $builder = $this->config->builder()
            ->issuedBy('cpa_ad_system') // Issuer
            ->permittedFor('cpa_ad_client') // Audience
            ->issuedAt($now) // Issued at
            ->canOnlyBeUsedAfter($now) // Not before
            ->expiresAt($expiresAt); // Expiration time

        // Add custom claims from payload
        foreach ($payload as $key => $value) {
            $builder = $builder->withClaim($key, $value);
        }

        return $builder->getToken($this->config->signer(), $this->config->signingKey())->toString();
    }

    /**
     * Parse and validate JWT token.
     */
    public function parseToken(string $token): ?Plain
    {
        try {
            $parsedToken = $this->config->parser()->parse($token);

            // Validate the token
            $constraints = $this->config->validationConstraints();
            if (! $this->config->validator()->validate($parsedToken, ...$constraints)) {
                return null;
            }

            return $parsedToken;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get all claims from token.
     */
    public function getAllClaims(string $token): array
    {
        $parsedToken = $this->parseToken($token);

        if (! $parsedToken) {
            return [];
        }

        return $parsedToken->claims()->all();
    }

    /**
     * Check if token is valid.
     */
    public function isValid(string $token): bool
    {
        return $this->parseToken($token) !== null;
    }

    /**
     * Refresh token (generate new token with same payload but extended expiry).
     */
    public function refreshToken(string $token, int $expiresInMinutes = 60): ?string
    {
        $parsedToken = $this->parseToken($token);

        if (! $parsedToken) {
            return null;
        }

        $claims = $parsedToken->claims()->all();

        // Remove system claims that will be regenerated
        unset($claims['iss'], $claims['aud'], $claims['iat'], $claims['nbf'], $claims['exp']);

        return $this->generateToken($claims, $expiresInMinutes);
    }
}
