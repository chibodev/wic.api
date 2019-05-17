<?php

declare(strict_types=1);

namespace App\Recipe\Command;

use App\Recipe\Event\ApiUserEvent;
use App\Recipe\PublicInterface\ApiUser;
use App\Recipe\ValueObject\ApiUserRole;
use Exception;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UnexpectedValueException;

class ApiKeyGeneratorCommand extends Command
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct();
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function configure(): void
    {

        $this->setName('api:create:key')
            ->setDescription('Generates an api key.')
            ->addOption(
                'role',
                null,
                InputOption::VALUE_REQUIRED,
                sprintf('Role of user defaults to %s', ApiUserRole::ROLE_API_USER),
                ApiUserRole::ROLE_API_USER
            )
        ;
    }
    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $uuid = $uuid = Uuid::uuid4();
        $username = 'wic_api_user-'.$uuid->toString();

        try {
            $role = new ApiUserRole($input->getOption('role'));
        } catch (InvalidArgumentException | UnexpectedValueException $e) {
            throw new RuntimeException('The entered role is invalid');
        }

        $apiUserEvent = new ApiUserEvent($username, $role);
        $this->eventDispatcher->dispatch(ApiUser::EVENT, $apiUserEvent);
        $apiUser = $apiUserEvent->getResult();

        $output->writeln(sprintf('Api Key: %s', $apiUser->getApiKey()));
    }
}
