<?php

namespace App\AMS\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\AMS\Repository\AdministratorRepository")
 * @ORM\Table(name="fos_user")
 */
class Administrator extends BaseUser
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

}
