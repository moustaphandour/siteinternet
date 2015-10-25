<?php

namespace Tapha\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TaphaBlogExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('tapha_blog.blog_title', $config['blog_title']);
        $container->setParameter('tapha_blog.blog_rss_description', $config['blog_rss_description']);
        $container->setParameter('tapha_blog.robot_email', $config['robot_email']);  
        $container->setParameter('tapha_blog.max_per_page', $config['max_per_page']);    
        $container->setParameter('tapha_blog.hosts_tmp_mail', $config['hosts_tmp_mail']);
        $container->setParameter('tapha_blog.min_elapsed_time_comment', $config['min_elapsed_time_comment']);   
        $container->setParameter('tapha_blog.menu_display_accueil', $config['menu_display_accueil']); 
        $container->setParameter('tapha_blog.facebook_api_id', $config['facebook_api_id']);
    }
}