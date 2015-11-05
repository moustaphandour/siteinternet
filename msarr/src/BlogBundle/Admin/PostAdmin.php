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

class PostAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //$object = $formMapper->getData();
        $formMapper
            ->add('title', 'text',
                array(
                    'required' => true,
                    'label' => 'Title:',
                    'attr' => array(
                        'placeholder' => 'Enter title of the article'
                    )
                ))
            ->add('categories', 'entity', array(
                'class' => 'Application\Sonata\ClassificationBundle\Entity\Category',
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'attr' => array(
                    'placeholder' => 'Select category'
                )))
            ->add('excerptPhoto', 'sonata_type_model_list', array('required' => false), array(
                    'link_parameters' => array(
                        'context'      => 'news',
                        'hide_context' => true,
                    ),
                ))
            ->add('excerpt', 'textarea',
                array(
                    'required' => false,
                    'label' => 'Excerpt text:',
                    'attr' => array(
                        'rows'  => 2,
                        'placeholder' => 'Enter excerpt text'
                    )
                ))
            ->add('content', 'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Content:',
                    'attr' => array(
                    )
                ))
            ->add('tags','text', array(
                'required' => false,
                'attr' => array(
                    "class" => "form-control form-control--lg margin--halfb",
                    "placeholder" => "Enter tags",
                    "data-role" => "tagsinput"
                )
                ))
            ->add('metaExtras', 'hidden', array(
                'mapped' => false
            ))
            ->add('author', 'entity', array(
                    'label' => 'Author:',
                    'required' => true,
                    'class' => 'Application\Sonata\UserBundle\Entity\User',
                    'placeholder' => 'Select author',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->where('a.roles like :type')
                            ->orderBy('a.username', 'ASC')
                            ->setParameter('type', '%ROLE_BLOG_ADMIN%');

                    },
                    'attr' => array(
                        'class' => 'form-control form-control--lg color-placeholder',
                    )
                ))
            ->add('status', 'choice', array(
                    'label' => 'Status:',
                    'choices' => array(
                        Post::STATUS_PUBLISHED => "Published",
                        Post::STATUS_DRAFTED => "Draft"
                    ),
                    'required' => true,
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