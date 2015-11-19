<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ArticleMetaAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('key', 'text', array(
                'label' => 'Meta name:',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--halfb',
                    'placeholder' => 'Enter name of the meta tag'
                )
            ))
            ->add('value', 'textarea', array(
                'label' => 'Meta value:',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--halfb',
                    'rows' => 2,
                    'placeholder' => 'Enter value of the meta tag'
                )
            ));
        
       ;
    }
    

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('key')
            ->add('value')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('key')
            ->add('value')
       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('key')
            ->add('value')
       ;
    }
}