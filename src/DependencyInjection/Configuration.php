<?php


namespace Casisdead2772\PostcodeBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('postcode');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('getaddress')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('getaddress_apikey')->defaultNull()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}