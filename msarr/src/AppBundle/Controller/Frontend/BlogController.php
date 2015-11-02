<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AppBundle\Controller\Frontend;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BlogController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @Route("/", name="blog_index")
     * @Route("/")
     *
     * @param null $category
     * @param int  $depth
     * @param int  $deep
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function indexAction($category = null, $depth = 1, $deep = 0)
    {
        $category = $category ?: $this->get('sonata.classification.manager.category')->getRootCategories();
        return $this->render('BlogBundle::index.html.twig', array(
          'root_category' => $category,
          'depth'         => $depth,
          'deep'          => $deep + 1
        ));
    }
}