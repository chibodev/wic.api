<?php

declare(strict_types=1);

namespace App\Common\Tests\Unit\Security\Service;

use App\Common\Security\Service\AccessKeyService;
use Exception;
use PHPUnit\Framework\TestCase;

class AccessKeyServiceTest extends TestCase
{
    /** @var AccessKeyService */
    private $subject;

    public function setUp()
    {
        parent::setUp();

        $this->subject = new AccessKeyService();
    }

    public function testGenerateForApi(): void
    {
        $value = 'apiKey';

        $result = $this->subject->generateForApi($value);

        self::assertNotEmpty($result->getApiKey());
        self::assertNotEmpty($result->getHash());

    }
}
