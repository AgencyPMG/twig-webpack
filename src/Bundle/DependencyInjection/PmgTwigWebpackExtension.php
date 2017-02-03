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
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\Context\ContextInterface as AssetContext;
use Symfony\Component\Asset\Exception\InvalidArgumentException;
Use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use PMG\TwigWebpack\SimpleWebpack;
use PMG\TwigWebpack\SymfonyAssetsWebpack;
use PMG\TwigWebpack\Webpack;
use PMG\TwigWebpack\Twig\WebpackExtension;

final class PmgTwigWebpackExtension extends ConfigurableExtension
{
    public static function createWebpack(
        Packages $packages=null,
        AssetContext $context=null,
        $devMode,
        $baseUrl
    ) {
        if (!$packages) {
            return new SimpleWebpack($devMode, $baseUrl);
        }

        try {
            $package = $packages->getPackage('webpack');
        } catch (InvalidArgumentException $e) {
            $package = new UrlPackage($baseUrl, new EmptyVersionStrategy(), $context);
            $packages->addPackage('webpack', $package);
        }

        return new SymfonyAssetsWebpack($devMode, $package);
    }

    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $config, ContainerBuilder $container)
    {
        foreach ($config as $key => $val) {
            $container->setParameter(sprintf('pmg_twig_webpack.%s', $key), $val);
        }

        $container->setDefinition('pmg_twig_webpack.webpack', new Definition(Webpack::class, [
                new Reference('assets.packages', ContainerInterface::NULL_ON_INVALID_REFERENCE),
                new Reference('assets.context', ContainerInterface::NULL_ON_INVALID_REFERENCE),
                '%pmg_twig_webpack.dev_mode%',
                '%pmg_twig_webpack.base_url%',
            ]))
            ->setFactory([__CLASS__, 'createWebpack']);

        $container->setDefinition('pmg_twig_webpack.extension', new Definition(
            WebpackExtension::class,
            [new Reference('pmg_twig_webpack.webpack')]
        ))->addTag('twig.extension');
    }
}
