<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify;

abstract class NodeConverter implements NodeConverterInterface
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $tagList;
    protected $node;


    /* PUBLIC METHODS
     *************************************************************************/
    public function __construct()
    {
    }


    /* PUBLIC METHODS
     *************************************************************************/
    public function canHandleNode(\DOMNode $node)
    {
        return in_array($node->nodeName, $this->tagList);
    }

    public function load(\DOMNode $node)
    {
        $this->node = $node;
        return $this;
    }

    public function save($nodeConverterFactory)
    {
        return $this->saveInnerHTML($nodeConverterFactory);
    }


    /* PROTECTED METHODS
     *************************************************************************/
    protected function getTagName()
    {
        return $this->node->nodeName;
    }

    protected function saveHTML()
    {
        return $this->node->ownerDocument->saveHTML($this->node);
    }

    protected function saveInnerHTML()
    {
        $html = '';
        $document = $this->node->ownerDocument;
        foreach ($this->node->childNodes as $childNode) {
            $html .= $document->saveHTML($childNode);
        }
        return $html;
    }

    protected function saveRecursive($nodeConverterFactory)
    {
        $export = '';
        foreach ($this->node->childNodes as $childNode) {
            $childNodeConverter = $nodeConverterFactory->instanceNodeConverter($childNode);
            if ($childNodeConverter) {
                $export .= $childNodeConverter->save($nodeConverterFactory);
            }
        }
        return $export;
    }

}