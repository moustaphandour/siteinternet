<?php

namespace Tapha\BlogBundle\Form\AdminBlog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'form.post.title', 'translation_domain' => 'TaphaBlogBundle'))
            ->add('accroche','ckeditor', array('config_name' => 'default', 'label' => 'form.post.hang', 'translation_domain' => 'TaphaBlogBundle'))
            ->add('article','ckeditor', array('config_name' => 'extended'))
            ->add('categories', null, array('label' => 'form.post.categories',
                                            'translation_domain' => 'TaphaBlogBundle',
                                            'query_builder' => function(NestedTreeRepository $er){ return $er->getNodesHierarchyQueryBuilder(); },
                                            'property'      => 'selectRender'))
            ->add('publied', null, array('label' => 'form.post.publication', 'translation_domain' => 'TaphaBlogBundle'))
        ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tapha\BlogBundle\Entity\AdminBlog\Post'
        ));
    }

    public function getName()
    {
        return 'tapha_blogbundle_blog_posttype';
    }
}
