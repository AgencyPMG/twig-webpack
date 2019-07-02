<?php
/*
 * This file is part of pmg/twig-webpack
 *
 * Copyright (c) PMG <https://www.pmg.com>
 *
 * For full copyright information see the LICENSE file distributed
 * with this source code.
 */

namespace PMG\TwigWebpack\Bundle\DependencyInjection;

use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use PMG\TwigWebpack\SimpleWebpack;
use PMG\TwigWebpack\SymfonyAssetsWebpack;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class PmgTwigWebpackExtension extends ConfigurableExtension
{
    public static function createWebpack(Packages $packages=null, $devMode, $baseUrl)
    {
        if (!$packages) {
            return new SimpleWebpack($devMode, $baseUrl);
        }

        try {
            $package = $packages->getPackage('webpack');
        } catch (InvalidArgumentException $e) {
            $package = SymfonyAssetsWebpack::createPackage($baseUrl);
            $packages->addPackage('webpack', $package);
        }

        return new SymfonyAssetsWebpack($devMode, $package);
    }

    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        foreach ($config as $key => $val) {
            $container->setParameter(sprintf('pmg_twig_webpack.%s', $key), $val);
        }

        $loader->load('services.xml');
    }
}
