<?php

/* This file is part of the Markdownify project, which is under LGPL license */

namespace Markdownify;

class Parser
{



    /* ATTRIBUTES
     *************************************************************************/
    const NODE_INVALID_CONVERSION = 1;
    const NODE_CONVERSION_DONE = 2;

    protected static $preFormattedContext = false;



    /* PUBLIC METHODS
     *************************************************************************/
    public function fromString($html, AbstractConverter $converter) {
        $node = new \DOMDocument();
        $node->loadHTML($html);
        $rootConvertedNode = $this->parse($node, $converter);
        if (! $rootConvertedNode) {
            return '';
        }
        return $rootConvertedNode->compile();
    }



    /* PROTECTED METHODS
     *************************************************************************/
    protected  function parse($node, AbstractConverter $converter) {
        $convertedNode = new ConvertedNode();
        $status = $converter->convertNode($node, $convertedNode);
        if ($status === static::NODE_INVALID_CONVERSION) {
            return false;
        }
        if ($node->hasChildNodes() && $status !== static::NODE_CONVERSION_DONE) {
            foreach ($node->childNodes as $childNode) {
                if ($convertedChildNode = $this->parse($childNode, $converter)) {
                    $convertedNode->childNodes[] = $convertedChildNode;
                }
            }
        }
        return $convertedNode;
    }
}
