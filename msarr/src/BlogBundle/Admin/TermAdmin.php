<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class TermAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'Title:',
                'attr' => array(
                    'placeholder' => 'Enter title'
                )
            ))
            ->add('slug', 'text', array(
                'required' => false,
                'label' => 'Slug:',
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--b',
                    'placeholder' => 'Slug will be generated automatically from title or you can add it manually'
                )
            ))
        
       ;
    }
    

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('title')
            ->add('slug')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('slug')
       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('slug')
       ;
    }
}