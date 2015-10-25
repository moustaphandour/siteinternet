<?php
// src/AppBundle/Admin/PostAdmin.php

namespace BlogBundle\Admin;

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
        $formMapper
            ->add('image', 'sonata_type_admin', 
                array('delete' => false
                ))
            ->add('title', 'text',
                array(
                    'required' => true,
                    'label' => 'Title:',
                    'attr' => array(
                        'class' => 'form-control form-control--lg margin--b',
                        'placeholder' => 'Enter title of the article'
                    )
                ))
            ->add('content', 'ckeditor', array(
                'config_name' => 'extended'
                ))
            ->add('author', 'entity', array(
                'class' => 'BlogBundle\Entity\User'
            ))
             ->add('categories', 'entity', array(
                'class' => 'BlogBundle\Entity\Taxonomy'
            ))
       ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('title')
            ->add('author')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('slug')
            ->add('author')
       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
           ->add('title')
           ->add('slug')
           ->add('author')
       ;
    }


    public function prePersist($page) {
        $this->manageEmbeddedImageAdmins($page);
    }
    public function preUpdate($page) {
        $this->manageEmbeddedImageAdmins($page);
    }
    private function manageEmbeddedImageAdmins($page) 
    {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldDescription->getType() === 'sonata_type_admin' &&
                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
                $associationMapping['targetEntity'] === 'BlogBundle\Entity\Image'
            ) {
                $getter = 'get' . $fieldName;
                $setter = 'set' . $fieldName;

                /** @var Image $image */
                $image = $page->$getter();
                if ($image) 
                {
                    if ($image->getFile())
                    {
                        // update the Image to trigger file management
                        $image->refreshUpdated();
                        $image->setCreatedAt(new \DateTime('now'));
                    } 
                    elseif (!$image->getFile() && !$image->getFilename())
                     {
                        // prevent Sf/Sonata trying to create and persist an empty Image
                        $page->$setter(null);
                    }
                }
            }
        }
    }

}