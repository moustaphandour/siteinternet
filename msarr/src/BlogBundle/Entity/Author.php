<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="author")
 */
class Author extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Required by User
     *
     * @ORM\Column(name="blog_display_name", type="string")
     */
    protected $blogDisplayName = "";

    public function getBlogDisplayName()
    {
        return $this->blogDisplayName;
    }

    public function setBlogDisplayName($blogDisplayName)
    {
        $this->blogDisplayName = $blogDisplayName;

        return $this;
    }

    public function getCommenterDisplayName()
    {
        return $this->blogDisplayName;
    }
}