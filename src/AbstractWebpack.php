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

/**
 * ABC for webpack implementations. Provides a way to set `isDevMode`
 *
 * @since 1.0
 */
abstract class AbstractWebpack implements Webpack
{
    /**
     * @var bool
     */
    private $devMode;

    public function __construct($devMode)
    {
        $this->devMode = filter_var($devMode, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * {@inheritdoc}
     */
    public function isDevMode()
    {
        return $this->devMode;
    }
}
