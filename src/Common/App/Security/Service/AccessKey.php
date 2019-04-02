<?php

declare(strict_types=1);

namespace App\Common\App\Security\Service;

use App\Common\App\Security\DTO\AccessKey as AccessKeyDTO;
use Exception;

interface AccessKey
{
    /**
     * @throws Exception
     */
    public function generateForApi(string $value): AccessKeyDTO;
}
