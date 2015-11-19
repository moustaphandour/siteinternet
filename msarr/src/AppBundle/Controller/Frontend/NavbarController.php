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
use ED\BlogBundle\Model\Entity\Taxonomy;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavbarController extends Controller
{
    public function indexAction()
    {
        $categories = $this->get('app_repository_taxonomy')
              ->createQueryBuilder('c')
              ->where('c.parent IS NULL')
              ->andWhere('c.type = :categoryType')
              ->setParameter('categoryType', Taxonomy::TYPE_CATEGORY)
              ->getQuery()
              ->getResult();
        return $this->render('AppBundle:Frontend/Blog:blog_navbar.html.twig', array(
              'categories' => $categories,
          ));
    }
}