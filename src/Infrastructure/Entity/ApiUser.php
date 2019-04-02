<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\ValueObject\ApiUserRole;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\ApiUserRepository")
 */
class ApiUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $hash;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->isActive = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    public function setRoles(ApiUserRole $role): void
    {
        $this->roles[] = $role->getValue();
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_API_USER
        $roles[] = 'ROLE_API_USER';

        return array_unique($roles);
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function IsActive(): bool
    {
        return $this->isActive;
    }
}
