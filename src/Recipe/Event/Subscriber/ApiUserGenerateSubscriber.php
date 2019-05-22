<?php

declare(strict_types=1);

namespace App\Recipe\Event\Subscriber;

use App\Recipe\Entity\ApiUser as ApiUserEntity;
use App\Recipe\Event\ApiUserEvent;
use App\Recipe\PublicInterface\ApiUser;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ApiUserGenerateSubscriber implements EventSubscriberInterface
{
    private $apiUserService;

    public function __construct(ApiUser $apiUserService)
    {
        $this->apiUserService = $apiUserService;
    }

    public static function getSubscribedEvents(): array
    {
        return [ ApiUser::EVENT => ['onApiUserGenerate', 250 ]];
    }

    /**
     * @throws Exception
     */
    public function onApiUserGenerate(ApiUserEvent $event): void
    {
        $accessKeyDTO = $this->apiUserService->createKey($event->getApiUserUuid());

        $apiUser = new ApiUserEntity();
        $apiUser->setRoles($event->getRole());
        $apiUser->setHash($accessKeyDTO->getHash());
        $apiUser->setUuid($event->getApiUserUuid());

        $event->setAccessKey($accessKeyDTO);

        $this->apiUserService->save($apiUser);

        $event->stopPropagation();
    }
}
