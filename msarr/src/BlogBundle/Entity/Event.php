<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * 
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\Repository\EventRepository")
 */
class Event
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var datetime $time
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;
    /**
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;
     /**
     * @var string $gmaps
     *
     * @ORM\Column(name="gmaps", type="string", length=512, nullable=true)
     * @Assert\Url()
     */
    private $gmaps;
    /**
     * @var text $details
     *
     * @ORM\Column(name="details", type="text", nullable=true)
     */

    private $details;
    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Event")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Team", mappedBy="event")
     */
    protected $teams;
    /**
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Event", mappedBy="parent")
     */
    protected $children;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

        /**
     * @param Event $child
     *
     * @deprecated only used by the AdminHelper
     */
    public function addChildren(Event $child)
    {
        $this->addChild($child, true);
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(Event $child)
    {
        $this->children[] = $child;
        $child->setParent($this, true);
        
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(Event $childToDelete)
    {
        foreach ($this->getChildren() as $pos => $child) {
            if ($childToDelete->getId() && $child->getId() === $childToDelete->getId()) {
                unset($this->children[$pos]);

                return;
            }

            if (!$childToDelete->getId() && $child === $childToDelete) {
                unset($this->children[$pos]);

                return;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function setChildren($children)
    {
        $this->children = new ArrayCollection();

        foreach ($children as $category) {
            $this->addChild($category);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasChildren()
    {
        return count($this->children) > 0;
    }
    
     /**
     * @return mixed
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param mixed $teams
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;

        return $this;
    }

    public function addTeam(Team $team)
    {
        if(!$this->teams->contains($team))
        {
            $team->setEvent($this);
            $this->teams->add($team);
        }
    }

    public function removeTeam(Team $team)
    {
        if($this->teams->contains($team))
        {
            $team->setEvent(null);
            $this->teams->removeElement($team);
        }
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent(Event $parent=null)
    {
        $this->parent = $parent;

        return $this;
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set time
     *
     * @param datetime $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }
    /**
     * Get time
     *
     * @return datetime 
     */
    public function getTime()
    {
        return $this->time;
    }
    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }
    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }
    /**
     * Set details
     *
     * @param text $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }
    /**
     * Get details
     *
     * @return text 
     */
    public function getDetails()
    {
        return $this->details;
    }

    public function __toString()
    {
        return $this->getName() ?: 'n/a';
    }
    /**
     * Set Google Maps
     *
     * @param string $gmaps
     */
    public function setGmaps($gmaps) {
        $this->gmaps = $gmaps;
    }
    /**
     * Get Google Maps
     *
     * @return string
     */
    public function getGmaps() {
        return $this->gmaps;
    }
}