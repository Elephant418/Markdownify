<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\MarkdownConverter;

use \Markdownify\Converter\NodeConverter;

class ParagraphMarkdownConverter extends NodeConverter
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $tagList = array('p');


    /* PROTECTED METHODS
     *************************************************************************/
    public function __construct()
    {
        $this->escapingRegexList = array(
            array('@'.PHP_EOL.PHP_EOL.'+@m', PHP_EOL)
        );
    }
    
    protected function initialization()
    {
        $this->setLineBreaks(2);
    }
}