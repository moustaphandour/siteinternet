<?php
/**
 * Created by Eton Digital.
 * User: Vladimir Mladenovic (vladimir.mladenovic@etondigital.com)
 * Date: 12.5.15.
 * Time: 10.45
 */

namespace AppBundle\Controller\Frontend;

use BlogBundle\Entity\Repository\PostRepository;
use BlogBundle\Entity\Article;
use BlogBundle\Entity\Taxonomy;
use ED\BlogBundle\Handler\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
    private $eventRepository;
	/**
     * @Route("/", name="homepage")
     * @Route("/", name="blog_frontend_index")
     * @Route("/")
     */
   
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();

     //    $posts = $this->get('sonata.news.manager.post')->findAll();
        // $category = $this->get('sonata.classification.manager.category')->getRootCategories();
     //    return $this->render('AppBundle:Frontend/Blog:index.html.twig', array('en' => $posts ));
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('ed_blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getArticlesList(),
            'AppBundle:Frontend/Blog:index',
            'AppBundle:Frontend/Global:pagination',
            array(),
            Pagination::SMALL,
            null,
            $paginationTemplate = 'AppBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/blog/{slug}", name="frontend_blog_single_article")
     * @ParamConverter("article", class="BlogBundle\Entity\Article", converter="abstract_converter")
     */
    public function singleArticleAction($article)
    {
       
        $commentClass = $this->container->getParameter('blog_comment_class');
        $newComment = new $commentClass();
        $newComment
            ->setAuthor($this->getUser())
            ->setArticle($article);

        $form = $this->createForm('edcomment', $newComment);
        $comments =  $this->get("app_repository_comment")->findByArticle($article, $this->get("blog_settings")->getCommentsDisplayOrder());
        $commentsCount = $this->get("app_repository_comment")->findCountByArticle($article);

        return $this->render("AppBundle:Frontend/Blog:singleArticle.html.twig",
            array(
                'article' => $article,
                'form' => $form->createView(),
                'comments' => $comments,
                'commentsCnt' => $commentsCount
                ));
    }

    /**
     * @Route("/blog/category/{categorySlug}", name="frontend_blog_by_category")
     */
    public function byCategoryAction($categorySlug)
    {
        $taxonomyType = Taxonomy::TYPE_CATEGORY;
        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($categorySlug);

        if(!($taxonomy && $taxonomy->getType()==$taxonomyType))
        {
            throw new NotFoundHttpException("Category not found.");
        }

        $criteria['type'] = $taxonomyType;
        $criteria['value'] = $taxonomy;

        $paginator = $this->get('ed_blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getActiveArticlesByTaxonomy($categorySlug,$taxonomyType),
            'AppBundle:Frontend/Blog:index',
            'AppBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            Pagination::SMALL,
            null,
            $paginationTemplate = 'AppBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/blog/tag/{tagSlug}", name="frontend_blog_by_tag")
     */
    public function byTagAction($tagSlug)
    {
        $taxonomyType = Taxonomy::TYPE_CATEGORY;

        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($tagSlug);

        if(!($taxonomy && $taxonomy->getType()==$taxonomyType))
        {
            throw new NotFoundHttpException("Tag not found.");
        }

        $criteria['type'] = $taxonomyType;
        $criteria['value'] = $taxonomy;

        $paginator = $this->get('ed_blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getActiveArticlesByTaxonomy($tagSlug,$taxonomyType),
            'AppBundle:Frontend/Blog:index',
            'AppBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            Pagination::SMALL,
            null,
            $paginationTemplate = 'AppBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/blog/author/{username}", name="frontend_blog_by_author")
     * @ParamConverter("user", class="ED\BlogBundle\Interfaces\Model\BlogUserInterface", converter="abstract_converter")
     */
    public function byAuthorAction($user)
    {
        $criteria['type'] = "author";
        $criteria['value'] = $user;

        $paginator = $this->get('ed_blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getActiveArticlesByAuthor($user),
            'AppBundle:Frontend/Blog:index',
            'AppBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            Pagination::SMALL,
            null,
            $paginationTemplate = 'AppBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/blog/archive/{yearMonth}", name="frontend_blog_archive")
     */
    public function archiveAction($yearMonth)
    {
        $archive=explode('-',$yearMonth);
        $year=$archive[0];
        $month=(count($archive) > 1) ? $archive[1]: null ;

        if(!((int)$year == $year && (int)$year > 0 && $month && (int)$month == $month && (int)$month > 0 && (int)$month <= 12))
        {
            throw new NotFoundHttpException("Invalid archive period.");
        }

        $criteria['type'] = "archive";
        $criteria['value'] = array('year' => $year, 'month' => $month);

        $paginator = $this->get('ed_blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getArticlesInOneMonth($year,$month),
            'AppBundle:Frontend/Blog:index',
            'AppBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            Pagination::SMALL,
            null,
            $paginationTemplate = 'AppBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }
}
