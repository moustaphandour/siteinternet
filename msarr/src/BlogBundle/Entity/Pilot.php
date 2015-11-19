<?php
// src/AppBundle/Entity/User.php

namespace BlogBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pilotes")
 */
class Pilot extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        team::__construct();
        // your own logic
    }

    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $team;
    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam(Team $team=null)
    {
        $this->team = $team;

        return $this;
    }
    
    public function __toString()
    {
        return $this->getName() ?: 'n/a';
    }

}