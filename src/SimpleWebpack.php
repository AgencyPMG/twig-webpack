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
 * A webpack implemtnation that just uses a server URL.
 *
 * @since 1.0
 */
final class SimpleWebpack extends AbstractWebpack
{
    const DEFAULT_BASEURL = 'http://localhost:8080';

    /**
     * @var string
     */
    private $baseUrl;

    public function __construct($devMode, $baseUrl=null)
    {
        parent::__construct($devMode);
        $this->baseUrl = $baseUrl ? rtrim($baseUrl, '/') : self::DEFAULT_BASEURL;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($path)
    {
        return sprintf('%s/%s', $this->baseUrl, basename($path));
    }
}
