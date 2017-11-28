<?php

namespace Dameert\FrontendCms\DependencyInjection;

use Dameert\FrontendCms\Service\ContentService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class DameertFrontendCmsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $ContentDef = $container->getDefinition(ContentService::class);
        $ContentDef->addMethodCall('setContentPath', array($config['content_path']));
        $ContentDef->addMethodCall('setTemplatePath', array($config['template_path']));
    }
}