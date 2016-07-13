<?php
/*
 * This file is part of pmg/twig-webpack
 *
 * Copyright (c) PMG <https://www.pmg.com>
 *
 * For full copyright information see the LICENSE file distributed
 * with this source code.
 */

namespace PMG\TwigWebpack;

use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\Asset\UrlPackage;
Use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

/**
 * A `Webpack` implementation backed by the symfony assets component.
 *
 * @since 1.0
 */
final class SymfonyAssetsWebpack extends AbstractWebpack
{
    /**
     * An asset package that points to the webpack dev server.
     *
     * @var PackageInterface
     */
    private $webpackPackage;

    public function __construct($devMode, PackageInterface $webpackPackage)
    {
        parent::__construct($devMode);
        $this->webpackPackage = $webpackPackage;
    }

    public static function fromDevServerUrl($devMode, $devServer)
    {
        return new self($devMode, new UrlPackage($devServer, new EmptyVersionStrategy()));
    }

    public static function createDefault($devMode)
    {
        return self::fromDevServerUrl($devMode, 'http://localhost:8080');
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($path)
    {
        return $this->webpackPackage->getUrl($path);
    }
}
