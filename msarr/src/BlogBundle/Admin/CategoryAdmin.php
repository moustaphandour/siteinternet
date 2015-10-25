<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use BlogBundle\Handler\BlogUserHandler;
use BlogBundle\Entity\Taxonomy;
use BlogBundle\Admin\TermAdmin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class CategoryAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
       
        $formMapper
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'Title :',
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--b',
                    'placeholder' => 'Enter the name of the category'
                )
            ))
            ->add('slug', 'text', array(
                'required' => false,
                'label' => 'Description:',
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--b',
                    'placeholder' => 'Enter slug of the category'
                )
            ))
            ->add('description', 'text', array(
                'required' => false,
                'label' => 'Description:',
                'attr' => array(
                    'class' => 'form-control form-control--lg margin--b',
                    'placeholder' => 'Enter description of the category'
                )
            ))
            ->add('parent', 'entity', array(
                'class' => 'BlogBundle\Entity\Taxonomy',
                'placeholder' => 'Select parent category',
                'label' => 'Description:',
                ))
            ->add('type', 'hidden', array(
                'data' => Taxonomy::TYPE_CATEGORY
            ))
            ->add('children', 'entity', array(
                'class' => 'BlogBundle\Entity\Taxonomy',
                'placeholder' => 'Select parent category',
                'label' => 'Description:',
                ))
            ->add('type', 'hidden', array(
                'data' => Taxonomy::TYPE_CATEGORY
            ))
       ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('title')
            ->add('parent')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('blogDisplayName')
            ->add('role')
       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
           ->add('blogDisplayName')
           ->add('role')
       ;
    }
}