<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxonomy_Relation
 *
 * @ORM\Table(name="taxonomy_relation")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\Repository\TaxonomyRepository")
 */

class TaxonomyRelation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Article", inversedBy="taxonomyRelations")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $article;

    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Taxonomy")
     * @ORM\JoinColumn(name="taxonomy_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $taxonomy;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }

    /**
     * @param mixed $taxonomy
     */
    public function setTaxonomy(BlogTaxonomy $taxonomy)
    {
        $this->taxonomy = $taxonomy;
        return $this;
    }


}