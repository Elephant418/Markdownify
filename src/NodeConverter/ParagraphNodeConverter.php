<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\NodeConverter;

class ParagraphNodeConverter extends InlineNodeConverter
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