<?php


namespace BlogBundle\Handler;

use BlogBundle\Entiy\Article;

class ObjectGenerator
{
    protected $object;
    protected $class;
    protected $constants;
    protected $metaDataClass;

    function __construct($class, $metaDataClass)
    {
        $this->class = new \ReflectionClass($class);
        $this->object = new $class();
        $this->constants = $this->class->getConstants();
        $this->metaDataClass = $metaDataClass;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function setProperty(&$object, $property, $value)
    {
        $setter = 'set' . ucfirst($property);

        if($this->class->hasProperty($property))
        {
            $object->$setter($value);
        }

        return $object;
    }

    public function getConstant($property)
    {
        return $this->constants[ $property ];
    }

    public function generateDraftFromArticle(Article $article)
    {
        $class = $this->class->name;
        $draft = new $class();

        $this->loadArticle($draft, $article);

        $draft
            ->setStatus( Article::STATUS_DRAFTED )
            ->setParent($article);

        return $draft;
    }

    /**
     * Will synchronize changes made on Draft to the master article and set it 'As Published'
     *
     * @param Article $article
     * @param Article $draft
     * @return Article
     */
    public function generateArticleFromDraft(Article &$article, Article $draft)
    {

        $this->loadArticle($article, $draft);

        $article
            ->setStatus( Article::STATUS_PUBLISHED )
            ->setParent(null);

        return $article;
    }

    public function generateNewArticleFromDraft(Article $draft)
    {
        $articleClass = get_class($draft);
        $article = new $articleClass();

        $this->generateArticleFromDraft($article, $draft);

        return $article;
    }

    public function generateNewDraftFromLatestRevision(&$latestDraft, $article)
    {
        // last edited version of the document will be shown to user on edit page
        if(!$latestDraft)
        {
            $draft = $this->generateDraftFromArticle($article);
            $latestDraft = $draft;
        }
        else
        {
            $draft = $this->generateDraftFromArticle($latestDraft);
            $draft->setParent($article);
        }

        //to enable slug edit
        $draft
            ->setSlug( $article->getSlug() );

        return $draft;
    }

    public function loadArticle(Article &$destination, Article $src, $skipSlug = false, $skipMetaData = false)
    {
        $destination
            ->setContent( $src->getContent() )
            ->setTitle( $src->getTitle() )
            ->setExcerpt( $src->getExcerpt() )
            ->setExcerptPhoto( $src->getExcerptPhoto())
            ->setAuthor( $src->getAuthor())
            ->setCategories( $src->getCategories())
            ->setTags( $src->getTags())
           ;

        if(!$skipMetaData)
        {
            //remove old metaData
            foreach($destination->getMetaData() as $destMeta)
            {
                if($src->getMetaByKey($destMeta->getKey()) === false)
                {
                    $destination->removeMetaData($destMeta);
                }
            }

            //add new metaData
            foreach($src->getMetaData() as $srcMeta)
            {
                if($destination->hasMetaData($srcMeta) === false && $srcMeta->getKey()!= 'writing_locked')
                {
                    $destMeta = $destination->getMetaByKey($srcMeta->getKey() );

                    if ( $destMeta === false)
                    {
                        $metaDataClass = $this->metaDataClass;
                        $destMeta = new $metaDataClass();
                    }

                    $destMeta
                        ->setKey($srcMeta->getKey())
                        ->setValue($srcMeta->getValue())
                        ->setArticle($destination);

                    $destination
                        ->addMetaData($destMeta);
                }
            }
        }

        if(!$skipSlug)
        {
            $destination
                ->setSlug($src->getSlug());
        }
    }
}