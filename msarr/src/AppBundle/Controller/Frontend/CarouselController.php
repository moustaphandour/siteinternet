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

class CarouselController extends Controller
{
     
    public function indexAction()
    {
        $posts = $this->get('app_repository_article')->getActiveArticles(3);

        //$posts = $this->get('sonata.news.manager.post')->findAll();
        return $this->render('AppBundle:Frontend/Blog:blog_carousel.html.twig', array('posts' => $posts));
    }

}
