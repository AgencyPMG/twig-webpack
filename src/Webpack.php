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
 * Main entrypoint and service object for the webpack dev server and debug mode
 * information.
 *
 * @since 1.0
 */
interface Webpack
{
    /**
     * Whether or not we're in dev mode.
     *
     * @return bool True if we're in dev mode.
     */
    public function isDevMode();

    /**
     * Get a URL with the webpack dev server base url pre-pended.
     *
     * @param string $path The path to use
     * @return string The path with the server base url pre-pended
     */
    public function getUrl($path);
}
