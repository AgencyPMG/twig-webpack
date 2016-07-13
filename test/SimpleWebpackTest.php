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

class SimpleWebpackTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUrlReturnsAUrlPrefixedWithTheProvidedBasePath()
    {
        $wb = new SimpleWebpack(true, '/other/place/');

        $this->assertEquals('/other/place/test.js', $wb->getUrl('test.js'));
    }

    public function testGetUrlUsesDefaultBaseUrlWhenNoneIsProvided()
    {
        $wb = new SimpleWebpack(true);

        $this->assertEquals('http://localhost:8080/test.js', $wb->getUrl('test.js'));
    }
}
