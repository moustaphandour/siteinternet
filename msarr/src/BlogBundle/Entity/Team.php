<?php


namespace BlogBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\Repository\TeamRepository")
 */

class Team
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $name;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    /**
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Pilot", mappedBy="team")
     */
    protected $pilots;

    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Event", inversedBy="teams")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $event;
    
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->pilots = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPilots()
    {
        return $this->pilots;
    }

    /**
     * @param mixed $pilots
     */
    public function setPilots($pilots)
    {
        $this->pilots = $pilots;

        return $this;
    }

    public function addPilot(Pilot $pilot)
    {
        if(!$this->pilots->contains($pilot))
        {
            $pilot->setTeam($this);
            $this->pilots->add($pilot);
        }
    }

    public function removePilot(Pilot $pilot)
    {
        if($this->pilots->contains($pilot))
        {
            $pilot->setTeam(null);
            $this->pilots->removeElement($pilot);
        }
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent(Event $event=null)
    {
        $this->event = $event;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function __toString()
    {
        return $this->getName() ?: 'n/a';
    }

}