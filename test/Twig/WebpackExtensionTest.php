<?php
/*
 * This file is part of pmg/twig-webpack
 *
 * Copyright (c) PMG <https://www.pmg.com>
 *
 * For full copyright information see the LICENSE file distributed
 * with this source code.
 */

namespace PMG\TwigWebpack\Twig;

use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use PMG\TwigWebpack\Webpack;
use PMG\TwigWebpack\SimpleWebpack;
use PMG\TwigWebpack\SymfonyAssetsWebpack;
use Twig\Loader\ArrayLoader;
use Twig\Environment;

class WebpackExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testWebpackBlockRendersReloadScriptInDevMode()
    {
        $twig = self::createTwig(new SimpleWebpack(true), [
            'test' => '{% webpack %}{% endwebpack %}',
        ]);

        $result = $twig->render('test');

        $this->assertContains(SimpleWebpack::DEFAULT_BASEURL.'/webpack-dev-server.js', $result);
    }

    public function testSymfonyWebpackRendersAssetsWithWebpackBaseUrlWhenInDevMode()
    {
        $twig = self::createTwig(SymfonyAssetsWebpack::createDefault(true), [
            'test' => <<<EOF
{% webpack %}
<script src="{{ asset('/test.js') }}"></script>
{% endwebpack %}
EOF
        ]);
        $twig->addExtension(new AssetExtension(new Packages(new Package(new EmptyVersionStrategy()))));

        $result = $twig->render('test');

        $this->assertContains('http://localhost:8080/webpack-dev-server.js', $result);
        $this->assertContains('http://localhost:8080/test.js', $result);
    }

    private static function createTwig(Webpack $webpack, array $templates)
    {
        $twig = new Environment(new ArrayLoader($templates));
        $twig->addExtension(new WebpackExtension($webpack));

        return $twig;
    }
}
