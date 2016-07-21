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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder();
        $root = $tree->root('pmg_twig_webpack');

        $root
            ->children()
            ->scalarNode('base_url')
                ->cannotBeEmpty()
                ->defaultValue('http://localhost:8080')
                ->info('The webpack dev server base URL')
            ->end()
            ->booleanNode('dev_mode')
                ->defaultValue('%kernel.debug%')
                ->info('Whether or not to put the bundle in dev mode (serve assets from the webpack dev server)')
            ->end()
        ;

        return $tree;
    }
}
