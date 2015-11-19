<?php


namespace BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use BlogBundle\Entity\User;
use BlogBundle\Entity\Post;
use Doctrine\ORM\Mapping;

/**
 * ArticleRepository
 */
class PostRepository extends EntityRepository
{
    public function getActiveArticles($limit = null)
    {
        $articleClass = $this->_entityName;

        $query = "SELECT a FROM $articleClass a
                  WHERE a.status= :published AND a.publishedAt <= :cur
                  ORDER BY a.publishedAt DESC"
        ;

        $query = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("published", Post::STATUS_PUBLISHED)
            ->setParameter('cur',  new \DateTime());

        if($limit)
        {
            $query->setMaxResults($limit);
        }

        $articles = $query->useQueryCache(true)->setQueryCacheLifetime(60)->getResult();

        return $articles;
    }
}