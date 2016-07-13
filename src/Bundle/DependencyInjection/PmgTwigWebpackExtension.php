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
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use PMG\TwigWebpack\SimpleWebpack;
use PMG\TwigWebpack\SymfonyAssetsWebpack;
use PMG\TwigWebpack\Twig\WebpackExtension;

final class PmgTwigWebpackExtension extends ConfigurableExtension
{
    public static function createAssetsWebpack(Packages $packages, $devMode, $baseUrl)
    {
        try {
            $package = $package->getPackage('webpack');
        } catch (InvalidArgumentException $e) {
            $package = SymfonyAssetsWebpack::createPackage($baseUrl);
            $packages->addPackage('webpack', $package);
        }

        return new SymfonyAssetsWebpack($devMode, $packge);
    }

    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $config, ContainerBuilder $container)
    {
        foreach ($config as $key => $val) {
            $container->setParameter(sprintf('pmg_twig_webpack.%s', $key), $val);
        }

        if ($container->hasDefinition('assets.packages')) {
            $webpack = $this->createAssetsWebpack();
        } else {
            $webpack = $this->createSimpleWebpack($config);
        }
        $container->setDefinition('pmg_twig_webpack.webpack', $webpack);

        $container->setDefinition('pmg_twig_webpack.extension', new Definition(
            WebpackExtension::class,
            [new Reference('pmg_twig_webpack.webpack')]
        ))->addTag('twig.extension');
    }

    private function assetsWebpackDefinition()
    {
        $def = new Definition(SymfonyAssetsWebpack::class, [
            '%pmg_twig_webpack.dev_mode%',
            '%pmg_twig_webpack.base_url%',
            new Reference('assets.packages'),
        ]);
        $def->setFactory([__CLASS__, 'createAssetsWebpack']);

        return $def;
    }

    private function simpleWebpackDefinition(array $config)
    {
        return new Definition(SimpleWebpack::class, [$config['dev_mode'], $config['base_url']]);
    }
}
