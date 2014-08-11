<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\Converter\NodeConverter;

use \Markdownify\Converter\NodeConverter;

class TextNodeConverter extends NodeConverter
{

    
    /* ATTRIBUTES
     *************************************************************************/
    protected $conversionType = self::NO_NESTED_CONVERSION;

    
    /* PUBLIC METHODS
     *************************************************************************/
    public function canHandleNode(\DOMNode $node)
    {
        if ($node->nodeType === XML_TEXT_NODE) {
            return true;
        }
        return false;
    }
}