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

use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use PMG\TwigWebpack\SimpleWebpack;
use PMG\TwigWebpack\SymfonyAssetsWebpack;

class PmgTwigWebpackExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testContainerWithoutAssetsCreatesASimpleWebpackInstance()
    {
        $c = $this->createContainer();
        $c->compile();

        $wb = $c->get('pmg_twig_webpack.webpack');

        $this->assertInstanceOf(SimpleWebpack::class, $wb);
    }

    public function testContainerWithAssetsAvailableCreatesSymfonyAssetsWebpack()
    {
        $c = $this->createContainer();
        $c->set('assets.packages', new Packages(new Package(new EmptyVersionStrategy())));
        $c->compile();

        $wb = $c->get('pmg_twig_webpack.webpack');

        $this->assertInstanceOf(SymfonyAssetsWebpack::class, $wb);
    }

    private function createContainer()
    {
        $c = new ContainerBuilder();
        $c->registerExtension(new PmgTwigWebpackExtension());
        $c->loadFromExtension('pmg_twig_webpack', [
            'dev_mode' => true,
        ]);

        return $c;
    }
}
