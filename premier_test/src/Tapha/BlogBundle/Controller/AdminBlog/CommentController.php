<?php

namespace Tapha\BlogBundle\Controller\AdminBlog;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tapha\BlogBundle\Form\AdminBlog\CommentType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * AdminBlog\Comment controller.
 */
class CommentController extends Controller
{
    /**
     * Lists all AdminBlog\Comment entities.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TaphaBlogBundle:AdminBlog\Comment')->findAll();
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            $this->container->getParameter('tapha_blog.max_per_page')/*limit per page*/
        );       

        return array(
            'pagination' => $pagination
        );
    }

    /**
     * Displays a form to edit an existing AdminBlog\Comment entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TaphaBlogBundle:AdminBlog\Comment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdminBlog\Comment entity.');
        }

        $editForm = $this->createForm(new CommentType('admin'), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing AdminBlog\Comment entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Template("TaphaBlogBundle:AdminBlog\Comment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $t = $this->get('translator');

        $entity = $em->getRepository('TaphaBlogBundle:AdminBlog\Comment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdminBlog\Comment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CommentType('admin'), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', $t->trans('admin.form_submit_success', array(), 'TaphaBlogBundle'));

            return $this->redirect($this->generateUrl('badp_comment'));
        }
        $this->get('session')->getFlashBag()->add('error', $t->trans('admin.form_submit_error', array(), 'TaphaBlogBundle'));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a AdminBlog\Comment entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TaphaBlogBundle:AdminBlog\Comment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdminBlog\Comment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('badp_comment'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
