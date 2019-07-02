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

use Twig\Node\Node;
use Twig\Environment;
use Twig\NodeVisitor\AbstractNodeVisitor;

class AssetRewritingVisitor extends AbstractNodeVisitor
{
    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function doEnterNode(Node $node, Environment $env)
    {
        return $node;
    }

    /**
     * {@inheritdoc}
     */
    protected function doLeaveNode(Node $node, Environment $env)
    {
        if ($this->isAssetFunction($node) && $env->getFunction('webpack_asset')) {
            return new \Twig_Node_Expression_Function(
                'webpack_asset',
                $node->getNode('arguments'),
                $node->getTemplateLine()
            );
        }

        return $node;
    }

    private function isAssetFunction(Node $node)
    {
        return $node instanceof \Twig_Node_Expression_Function && $node->getAttribute('name') === 'asset';
    }
}
