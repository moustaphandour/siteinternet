<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use BlogBundle\Handler\BlogUserHandler;
use Doctrine\ORM\EntityRepository;
use BlogBundle\Entity\Post;
use BlogBundle\Admin\TermAdmin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class EventAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //$object = $formMapper->getData();
        $formMapper
            ->add('name')
            ->add('time')
            ->add('location')
            ->add('details')
            ->add('teams')
            ->add('children')
       ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('name')
            ->add('time')
            ->add('details')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('details')
       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
           ->add('name')
           ->add('details')
       ;
    }
}