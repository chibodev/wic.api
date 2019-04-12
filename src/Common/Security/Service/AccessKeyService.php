<?php

declare(strict_types=1);

namespace App\Common\Security\Service;

use App\Common\Security\DTO\AccessKey as AccessKeyDTO;
use Exception;

class AccessKeyService implements AccessKey
{
    public function generateForApi(string $value): AccessKeyDTO
    {
        $hash = password_hash($value, PASSWORD_BCRYPT);

        if(!$hash) {
            throw new Exception('Error while generating hash for key');
        }

        $apiKey =  base64_encode("$value.$hash");

        return new AccessKeyDTO($hash, $apiKey);
    }
}
