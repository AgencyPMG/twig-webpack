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

class AbstractWebpackTest extends \PHPUnit_Framework_TestCase
{
    public function testIsDevModeReturnsValuePassedToConstructor()
    {
        $wb = $this->getMockForAbstractClass(AbstractWebpack::class, [true]);

        $this->assertTrue($wb->isDevMode());
    }
}
