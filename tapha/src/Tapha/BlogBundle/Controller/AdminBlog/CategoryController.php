<?php

namespace Tapha\BlogBundle\Controller\AdminBlog;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tapha\BlogBundle\Entity\AdminBlog\Category;
use Tapha\BlogBundle\Form\AdminBlog\CategoryType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Blog\Category controller.
 */
class CategoryController extends Controller
{
    /**
     * Lists all Blog\Category entities.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TaphaBlogBundle:AdminBlog\Category')->getRootNodes('title');

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            $this->container->getParameter('tapha_blog.max_per_page')/*limit per page*/
        );        
        
        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * Creates a new Blog\Category entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Template("TaphaBlogBundle:AdminBlog\Category:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $t = $this->get('translator');

        $entity  = new Category();
        $form = $this->createForm(new CategoryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->orderingCategories();
            $this->get('session')->getFlashBag()->add('notice', $t->trans('admin.category.created', array(), 'TaphaBlogBundle'));

            return $this->redirect($this->generateUrl('badp_category', array('id' => $entity->getId())));
        }
        $this->get('session')->getFlashBag()->add('error', $t->trans('admin.form_submit_error', array(), 'TaphaBlogBundle'));

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Blog\Category entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Category();
        $form   = $this->createForm(new CategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Blog\Category entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TaphaBlogBundle:AdminBlog\Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog\Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Blog\Category entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Template("TaphaBlogBundle:AdminBlog\Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $t = $this->get('translator');

        $entity = $em->getRepository('TaphaBlogBundle:AdminBlog\Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog\Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->orderingCategories();
            $this->get('session')->getFlashBag()->add('notice', $t->trans('admin.form_submit_success', array(), 'TaphaBlogBundle'));
            
            return $this->redirect($this->generateUrl('badp_category'));
        }
        $this->get('session')->getFlashBag()->add('error', $t->trans('admin.form_submit_error', array(), 'TaphaBlogBundle'));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Blog\Category entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TaphaBlogBundle:AdminBlog\Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Blog\Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('badp_category'));
    }

    /**
     * Creates a form to delete a Blog\Category entity by id.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    private function orderingCategories(){
        $rootNodes = $this->getDoctrine()->getManager()->getRepository('TaphaBlogBundle:AdminBlog\Category')->getRootNodes();
        foreach($rootNodes AS $rootNode){
            $this->getDoctrine()->getManager()->getRepository('TaphaBlogBundle:AdminBlog\Category')->reorder($rootNode,'title');
        }
    }
}
