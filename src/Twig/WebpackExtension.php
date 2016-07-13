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

use PMG\TwigWebpack\Webpack;

final class WebpackExtension extends \Twig_Extension
{
    /**
     * @var Webpack
     */
    private $webpack;

    public function __construct(Webpack $webpack)
    {
        $this->webpack = $webpack;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return [
            new WebpackTokenParser($this->webpack),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('webpack_asset', [$this, 'getWebpackUrl']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pmg_twig_webpack';
    }

    /**
     * Get the webpack url for a given argument. `$package` is ignored here
     * but kept for compatiblity with the default `asset` function.
     *
     * @param $path The path to look up
     * @param $package ignored
     * @return string
     */
    public function getWebpackUrl($path, $package=null)
    {
        return $this->webpack->getUrl($path);
    }
}
