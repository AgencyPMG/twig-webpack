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

final class WebpackNode extends \Twig_Node
{
    /**
     * @var Webpack
     */
    private $webpack;

    public function __construct(Webpack $webpack, \Twig_NodeInterface $body, $lineno, $tag)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
        $this->webpack = $webpack;
    }

    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);
        $body = $this->getNode('body');

        if ($this->webpack->isDevMode()) {
            $compiler
                ->write(' echo')
                ->string(sprintf(
                    '<script type="text/javascript" src="%s"></script>',
                    $this->webpack->getUrl('/webpack-dev-server.js')
                ))
                ->raw(";\n");
            $body = $this->rewriteAssetFunctions($body, $compiler->getEnvironment());
        }

        $compiler->subcompile($body);
    }

    private function rewriteAssetFunctions(\Twig_Node $node, \Twig_Environment $env)
    {
        $traverser = new \Twig_NodeTraverser($env, [
            new AssetRewritingVisitor(),
        ]);
        return $traverser->traverse($node);
    }
}
