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

final class WebpackTokenParser extends \Twig_TokenParser
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
    public function parse(\Twig_Token $token)
    {
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(function (\Twig_Token $token) {
            return $token->test('endwebpack');
        }, true);
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        return new WebpackNode(
            $this->webpack,
            $body,
            $token->getLine(),
            $this->getTag()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'webpack';
    }
}
