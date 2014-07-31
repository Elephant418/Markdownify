<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\NodeConverter;

class TextNodeConverter extends InlineNodeConverter
{


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