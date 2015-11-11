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
    private $eventRepository;
	/**
     * @Route("/", name="homepage")
     * @Route("/", name="blog_frontend_index")
     * @Route("/")
     */
   
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();

        $posts = $this->get('sonata.news.manager.post')->findAll();
    	$category = $this->get('sonata.classification.manager.category')->getRootCategories();
        return $this->render('AppBundle:Frontend/Blog:index.html.twig', array('en' => $posts ));
    }

    public function showArticleAction(Post $post)
    {
        $routing_params = $post->getRoutingParams();
        unset($routing_params['id']);
        foreach ($routing_params AS $key => $value)
            if($this->get('request')->get($key) != $value)
                return $this->redirect($this->generateUrl('blog_post_show', $post->getRoutingParams()));
        
        $comment = new Comment();
        $comment->setIp($this->getRequest()->getClientIp());
        $form   = $this->createForm(new CommentType(), $comment);
        
        return array(
            'entity'            => $post,
            'form'              => $form->createView(),
            'facebook_api_id'   => $this->container->getParameter('mv_blog.facebook_api_id')
        );
    }

}
