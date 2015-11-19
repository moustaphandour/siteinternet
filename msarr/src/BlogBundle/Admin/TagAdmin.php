<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use BlogBundle\Entity\Taxonomy;

class TagAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('term', 'sonata_type_model', array(
                'required' => true,
                'label' => 'Title:',
                'attr' => array(
                    'placeholder' => 'Enter tag title'
                )
            ))
            ->add('description', 'text', array(
                'required' => false,
                'label' => 'Description:',
                'attr' => array(
                    'placeholder' => 'Enter tag description'
                )
            ))
            ->add('type', 'hidden', array(
                'data' => Taxonomy::TYPE_TAG
            ))
            ->remove('parent')
       ;
    }
    

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('term')
            ->add('type')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('term')
            ->add('type')
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