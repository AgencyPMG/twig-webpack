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

class SymfonyAssetsWebpackTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUrlReturnsAUrlWithTheWebpackBaseUrlAttached()
    {
        $wb = SymfonyAssetsWebpack::createDefault(true);

        $this->assertEquals('http://localhost:8080/test.js', $wb->getUrl('test.js'));
    }

    public function testGetUrlStripsAllButTheBasenameFromThePath()
    {
        $wb = SymfonyAssetsWebpack::createDefault(true);

        $this->assertEquals('http://localhost:8080/test.js', $wb->getUrl('/path/to/subdir/test.js'));
    }
}
