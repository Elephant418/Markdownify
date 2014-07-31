<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify;

abstract class NodeConverter implements NodeConverterInterface
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $tagList;
    protected $node;
    protected $escapingRegexList = array();


    /* CONSTRUCTOR METHODS
     *************************************************************************/
    public function __construct()
    {
    }


    /* PUBLIC METHODS
     *************************************************************************/
    public function canHandleNode(\DOMNode $node)
    {
        if ($node->nodeType === XML_ELEMENT_NODE) {
            return in_array($node->nodeName, $this->tagList);
        }
        return false;
    }

    public function load(\DOMNode $node)
    {
        $this->node = $node;
        return $this;
    }

    public function save($nodeConverterClassList)
    {
        return $this->saveInnerHTML($nodeConverterClassList);
    }

    public function escapeText($text) {
        foreach ($this->escapingRegexList as $escapingRegex) {
            if (isset($escapingRegex[0]) && isset($escapingRegex[1])) {
                $text = preg_replace($escapingRegex[0], $escapingRegex[1], $text);
            }
        }
        return $text;
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

    protected function saveRecursive($nodeConverterClassList)
    {
        $export = '';
        foreach ($this->node->childNodes as $childNode) {
            $childNodeConverterFactory = new NodeConverterFactory($nodeConverterClassList);
            $childNodeConverter = $childNodeConverterFactory->instanceNodeConverter($childNode);
            if ($childNodeConverter) {
                $export .= $childNodeConverter->save($nodeConverterClassList);
            }
        }
        return $export;
    }

}