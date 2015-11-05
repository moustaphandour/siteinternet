<?php
/**
 * Created by Eton Digital.
 * User: Vladimir Mladenovic (vladimir.mladenovic@etondigital.com)
 * Date: 12.5.15.
 * Time: 10.45
 */

namespace AppBundle\Controller\Frontend;

use BogBundle\Entity\Repository\PostRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
	/**
     * @Route("/", name="homepage")
     * @Route("/", name="blog_frontend_index")
     * @Route("/")
     */
   
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BlogBundle:Post')->getActiveArticles(10);
        $posts = $this->get('sonata.news.manager.post')->findAll();
    	$category = $this->get('sonata.classification.manager.category')->getRootCategories();
        return $this->render('AppBundle:Frontend/Blog:index.html.twig', array(
              'root_category' => $category,
              'en' => $posts
          ));
    }
}
