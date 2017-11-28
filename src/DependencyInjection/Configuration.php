<?php

namespace Dameert\FrontendCms\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dameert_frontend_cms');

        $rootNode
            ->children()
            ->scalarNode('content_path')->defaultValue('')->end()
            ->scalarNode('template_path')->defaultValue('')->end()
        ;

        return $treeBuilder;
    }
}