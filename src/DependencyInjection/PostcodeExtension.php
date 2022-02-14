<?php

namespace Casisdead2772\PostcodeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PostcodeExtension extends Extension {
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        foreach($config as $service => $key){
            $selectedKey = $service.'_apikey';

            if(isset($key[$selectedKey])){
                $container->setParameter($selectedKey, $key[$selectedKey]);
            } else {
                $container->removeDefinition('postcode.'.$service);
            }
        }
    }
}
