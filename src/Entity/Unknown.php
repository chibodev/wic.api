<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnknownRepository")
 */
class Unknown
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $term;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $counter;

    /**
     * @throws Exception
     */
    public function __construct(string $term)
    {
        $this->term = $term;
        $this->createdAt = new DateTimeImmutable();
        $this->counter = 1;
    }

    public function getTerm(): string
    {
        return $this->term;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function updateCounter(): void
    {
        $this->counter++;
    }
}
