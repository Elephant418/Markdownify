<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\Markdown\Node;

use \Markdownify\Converter\Node;

class ParagraphMarkdownNode extends Node
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $tagList = array('p');


    /* PROTECTED METHODS
     *************************************************************************/
    protected function initialization()
    {
        $this->setLineBreaks(2);
    }
}