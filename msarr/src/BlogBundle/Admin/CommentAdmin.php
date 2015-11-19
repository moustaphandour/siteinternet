<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use BlogBundle\Entity\Taxonomy;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class CommentAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('comment')
            ->add('author')
            ->add('article')
            ->add('parent')
       ;
    }
    

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('comment')
            ->add('author')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('comment')
            ->add('author')
       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
           ->add('comment')
            ->add('author')
       ;
    }
}