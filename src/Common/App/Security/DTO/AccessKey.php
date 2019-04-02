<?php

declare(strict_types=1);

namespace App\Common\App\Security\DTO;

class AccessKey
{
    private $hash;
    private $apiKey;

    public function __construct(string $hash, string $apiKey)
    {
        $this->hash = $hash;
        $this->apiKey = $apiKey;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
