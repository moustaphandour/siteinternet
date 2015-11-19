<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use BlogBundle\Handler\UserHandler;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class UserAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('blogDisplayName')    
            ->add('roles', 'collection', array(
                   'type' => 'choice',
                   'options' => array(
                       'label' => false, /* Ajoutez cette ligne */
                       'choices' => $this->getBlogRolesArray()
                   )
               ))

        ;
    }
    

    public function getBlogRolesArray()
    {
        return array(
            'ROLE_BLOG_ADMIN' => 'Administrator',
            'ROLE_BLOG_EDITOR' => 'Editor',
            'ROLE_BLOG_AUTHOR' => 'Author',
            'ROLE_BLOG_CONTRIBUTOR' => 'Contributor'
        );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('blogDisplayName')
            ->add('roles')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('blogDisplayName')
            ->add('roles')
       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
           ->add('name')
            ->add('description')
            ->add('pilots')
       ;
    }
}