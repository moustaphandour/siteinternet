<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Doctrine\ORM\EntityRepository;
use BlogBundle\Entity\Article;

class ArticleAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text',
                array(
                    'required' => true,
                    'label' => 'Title:',
                    'attr' => array(
                        'class' => 'form-control form-control--lg margin--b',
                        'placeholder' => 'Enter title of the article'
                    )
                ))
            ->add('excerpt', 'textarea',
                array(
                    'required' => false,
                    'label' => 'Excerpt text:',
                    'attr' => array(
                        'class' => 'form-control form-control--lg margin--halfb',
                        'rows'  => 2,
                        'placeholder' => 'Enter excerpt text'
                    )
                ))
            ->add('excerptPhoto', 'sonata_type_model', array(
            'class' => 'Application\Sonata\MediaBundle\Entity\Media',
            'property' => 'name'
            ))
            ->add('content')
            ->add('author', 'sonata_type_model')
            ->add('categories')
            ->add('tags')
            ->add('metaData')
            ->add('status', 'choice', array(
                    'label' => 'Status:',
                    'choices' => array(
                        Article::STATUS_PUBLISHED => "Published",
                        Article::STATUS_DRAFTED => "Draft"
                    ),
                    'required' => true,
                    'attr' => array(
                        "class" => "form-control form-control--lg margin--halfb",
                    ),
            ))
        
       ;
    }
    

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('title')
            ->add('excerptPhoto')
            ->add('excerpt')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('excerptPhoto')
            ->add('excerpt')
       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('excerptPhoto')
            ->add('excerpt')
       ;
    }
}