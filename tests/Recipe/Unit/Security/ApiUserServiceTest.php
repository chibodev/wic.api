<?php

declare(strict_types=1);

namespace tests\Recipe\Tests\Unit\Security;

use App\Common\Exception\TokenAuthenticationException;
use App\Common\Security\DTO\AccessKey as AccessKeyDTO;
use App\Common\Security\Service\AccessKey;
use App\Recipe\Entity\ApiUser;
use App\Recipe\Repository\ApiUserRepository;
use App\Recipe\Security\ApiUserService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class ApiUserServiceTest extends TestCase
{
    /** @var AccessKey|ObjectProphecy */
    private $accessKey;
    /** @var ApiUserRepository|ObjectProphecy */
    private $repository;
    /** @var ApiUserService */
    private $subject;

    public function setUp()
    {
        parent::setUp();
        $this->accessKey = $this->prophesize(AccessKey::class);
        $this->repository = $this->prophesize(ApiUserRepository::class);

        $this->subject = new ApiUserService($this->accessKey->reveal(), $this->repository->reveal());}


    public function testCreateKey(): void
    {
        $userUuid = 'user_uuid';
        $accessKey = $this->prophesize(AccessKeyDTO::class);

        $accessKey->getApiKey()->willReturn('apiKey');
        $accessKey->getHash()->willReturn('hash');

        $this->accessKey->generateForApi($userUuid)->shouldBeCalled()->willReturn($accessKey->reveal());

        $result = $this->subject->createKey($userUuid);

        self::assertEquals('apiKey', $result->getApiKey());
        self::assertEquals('hash', $result->getHash());
    }

    public function testSave(): void
    {
        $apiUser = $this->prophesize(ApiUser::class);
        $this->repository->save($apiUser->reveal())->shouldBeCalled();

        $this->subject->save($apiUser->reveal());
    }

    public function testVerifyAccessWithInvalidApiKey(): void
    {
        $this->expectException(TokenAuthenticationException::class);
        $this->expectExceptionMessage('Access forbidden! Invalid access token');

        $this->repository->findOneBy(['uuid' => 'error'])->shouldNotBeCalled();
        $this->subject->verifyAccess('');
    }

    public function testVerifyAccessWithInvalidUser(): void
    {
        $apiKey = 'd2ljX2FwaV91c2VyLTIyZWZjODhiLWFlNDQtNGQ5NC1iODAxLWI3MTJiOGY1YjIyNy4kMnkkMTAkOUNwcHJVN2N4ZzFsSGdhL2ZWb3FuZUxkQnNWcXl5VmwvZTd4TUlCZjc3U3BYSlNUUUdDcHk=';

        $this->repository->findOneBy(Argument::any())->shouldBeCalled()->willReturn(null);

        $this->expectException(TokenAuthenticationException::class);
        $this->expectExceptionMessage('Access forbidden! Invalid user');

        $this->subject->verifyAccess($apiKey);

    }

    public function testVerifyAccessFails(): void
    {
        $apiKey = 'd2ljX2FwaV91c2VyLTIyZWZjODhiLWFlNDQtNGQ5NC1iODAxLWI3MTJiOGY1YjIyNy4kMnkkMTAkOUNwcHJVN2N4ZzFsSGdhL2ZWb3FuZUxkQnNWcXl5VmwvZTd4TUlCZjc3U3BYSlNUUUdDcHk=';
        $apiUser = $this->prophesize(ApiUser::class);

        $apiUser->getHash()->willReturn('fakeHash');
        $apiUser->getUuid()->willReturn('fakeUuid');
        $apiUser->getRoles()->willReturn(['role' => 'fakeRole']);

        $this->repository->findOneBy(Argument::any())->shouldBeCalled()->willReturn($apiUser->reveal());

        $this->expectException(TokenAuthenticationException::class);
        $this->expectExceptionMessage('Access forbidden! No user associated with token');

        $this->subject->verifyAccess($apiKey);
    }

    public function testVerifyAccessSuccessful(): void
    {
        $apiKey = 'd2ljX2FwaV91c2VyLTIyZWZjODhiLWFlNDQtNGQ5NC1iODAxLWI3MTJiOGY1YjIyNy4kMnkkMTAkOUNwcHJVN2N4ZzFsSGdhL2ZWb3FuZUxkQnNWcXl5VmwvZTd4TUlCZjc3U3BYSlNUUUdDcHk=';
        $apiUser = $this->prophesize(ApiUser::class);

        $apiUser->getHash()->shouldBeCalled()->willReturn('$2y$10$9CpprU7cxg1lHga/fVoqneLdBsVqyyVl/e7xMIBf77SpXJSTQGCpy');
        $apiUser->getUuid()->shouldBeCalled()->willReturn('wic_api_user-22efc88b-ae44-4d94-b801-b712b8f5b227');
        $apiUser->getRoles()->shouldBeCalled()->willReturn(['role' => 'API_USER_ROLE']);

        $this->repository->findOneBy(Argument::any())->shouldBeCalled()->willReturn($apiUser->reveal());

        $result = $this->subject->verifyAccess($apiKey);

        self::assertSame('wic_api_user-22efc88b-ae44-4d94-b801-b712b8f5b227', $result->getUsername());
        self::assertSame('$2y$10$9CpprU7cxg1lHga/fVoqneLdBsVqyyVl/e7xMIBf77SpXJSTQGCpy', $result->getPassword());
        self::assertSame(['role' => 'API_USER_ROLE'], $result->getRoles());

    }
}
