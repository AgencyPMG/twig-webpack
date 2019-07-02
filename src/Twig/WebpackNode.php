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
use Twig\Node\Node;
use Twig\Environment;
use Twig\Compiler;
use Twig\NodeTraverser;

final class WebpackNode extends Node
{
    /**
     * @var Webpack
     */
    private $webpack;

    public function __construct(Webpack $webpack, Node $body, $lineno, $tag)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
        $this->webpack = $webpack;
    }

    /**
     * {@inheritdoc}
     */
    public function compile(Compiler $compiler)
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

    private function rewriteAssetFunctions(Node $node, Environment $env)
    {
        $traverser = new NodeTraverser($env, [
            new AssetRewritingVisitor(),
        ]);
        return $traverser->traverse($node);
    }
}
