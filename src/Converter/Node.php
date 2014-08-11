<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\Converter;

abstract class Node implements NodeInterface
{

    /* const
     *************************************************************************/
    const NESTED_CONVERSION = 1;
    const NO_NESTED_CONVERSION = 2;
    const NO_CONVERSION = 3;
    

    /* ATTRIBUTES
     *************************************************************************/
    protected $node;
    

    /* NODE CONFIGURATION
     *************************************************************************/
    protected $tagList = array();
    protected $conversionType = self::NESTED_CONVERSION;
    protected $escapingRegexList = array();

    
    /* TEXT CONFIGURATION
     *************************************************************************/
    protected $prefix = '';
    protected $suffix = '';
    protected $lineBreaks = 0;


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
        $this->initialization();
        if ($this->conversionType == self::NESTED_CONVERSION) {
            $export = $this->saveNested($nodeConverterClassList);
        } else {
            if ($this->conversionType == self::NO_CONVERSION) {
                $export = $this->saveHTML($nodeConverterClassList);
            } else {
                $export = $this->saveInnerHTML($nodeConverterClassList);
            }
            $export = $this->getEscapedText($export, $nodeConverterClassList);
        }
        $export = $this->prefix.$export.$this->suffix;
        $export .= str_repeat("\n", $this->lineBreaks);
        return $export;
    }

    public function escapeText($text) {
        foreach ($this->escapingRegexList as $escapingRegex) {
            if (isset($escapingRegex[0]) && isset($escapingRegex[1])) {
                $text = preg_replace($escapingRegex[0], $escapingRegex[1], $text);
            }
        }
        return $text;
    }


    /* PROTECTED NODE CONVERTER METHODS
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
        if ($this->node->nodeType === XML_TEXT_NODE) {
            return $this->node->textContent;
        } else if ($this->node->hasChildNodes()) {
            foreach ($this->node->childNodes as $childNode) {
                $html .= $document->saveHTML($childNode);
            }
        } 
        return $html;
    }

    protected function saveNested($nodeConverterClassList)
    {
        $export = '';
        foreach ($this->node->childNodes as $childNode) {
            $childNodeFactory = new NodeFactory($nodeConverterClassList);
            $childNodeConverter = $childNodeFactory->instanceNodeConverter($childNode);
            if ($childNodeConverter) {
                $export .= $childNodeConverter->save($nodeConverterClassList);
            } else {
                echo 'Tag name unsupported: '.$childNode->nodeName.PHP_EOL;
            }
        }
        return $export;
    }


    /* PROTECTED TEXT CONVERTER METHODS
     *************************************************************************/
    protected function initialization()
    {
    }

    protected function getEscapedText($text, $nodeConverterClassList) {
        foreach ($nodeConverterClassList as $nodeConverterClass) {
            $nodeConverter = new $nodeConverterClass;
            $text = $nodeConverter->escapeText($text);
        }
        return $text;
    }

    protected function setLineBreaks($number)
    {
        $this->lineBreaks = $number;
        return $this;
    }

    protected function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    protected function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }

    protected function setWrapper($wrapper)
    {
        $this->prefix = $wrapper;
        $this->suffix = $wrapper;
        return $this;
    }

}