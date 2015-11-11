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

class NavbarController extends Controller
{
    public function indexAction()
    {
        $category = $this->get('sonata.classification.manager.category')->getRootCategories();
        return $this->render('AppBundle:Frontend/Blog:blog_navbar.html.twig', array(
              'root_category' => $category,
          ));
    }
}