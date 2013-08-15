<?php

/* This file is part of the Markdownify project, which is under LGPL license */

namespace Markdownify;

class AbstractConverter
{



    /* ATTRIBUTES
     *************************************************************************/
    protected $ignoreElements = array(
        'html',
        'body',
        'div',
        'span',
    );

    protected $dropElements = array(
        'script',
        'head',
        'style',
        'form',
        'area',
        'object',
        'param',
        'iframe',
    );



    /* PUBLIC METHODS
     *************************************************************************/
    public function convert($html) {
        $parser = new \Markdownify\Parser();
        return $parser->fromString($html, $this);
    }

    public function convertNode($node, &$convertedNode) {
        if (!$this->handleNode($node)) {
            return false;
        }

        switch ($node->nodeType) {
            case XML_TEXT_NODE:
                return $this->convertText($node, $convertedNode);
            case XML_ELEMENT_NODE:
                return $this->convertElement($node, $convertedNode);
            case XML_HTML_DOCUMENT_NODE:
                return $this->convertDocument($node, $convertedNode);
            case XML_PI_NODE:
            case XML_COMMENT_NODE:
                break;
        }

        return Parser::NODE_INVALID_CONVERSION;
    }



    /* PROTECTED METHODS
     *************************************************************************/
    protected function handleNode() {
        return true;
    }

    protected function convertText($node, &$convertedNode) {
        $convertedNode->startingText = $node->nodeValue;
    }

    protected function convertElement($node, &$convertedNode) {
        $functionName = 'ConvertElement_' . $node->tagName;
        if (method_exists($this, $functionName)) {
            return $this->$functionName($node, $convertedNode);
        }
        if (in_array($node->tagName, $this->ignoreElements)) {
            return null;
        }
        if (in_array($node->tagName, $this->dropElements)) {
            return Parser::NODE_INVALID_CONVERSION;
        }
        $html = $node->ownerDocument->saveHTML($node);
        $convertedNode->startingText = substr($html, 0, strpos($html, '>')+1);
        $convertedNode->endingText = substr($html, strrpos($html, '<'));
    }

    protected function convertDocument($node, &$convertedNode) {
        $convertedNode->endingText = PHP_EOL;
        return null;
    }
}
