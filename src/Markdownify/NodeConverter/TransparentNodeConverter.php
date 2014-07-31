<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\NodeConverter;

class TransparentNodeConverter extends \Markdownify\NodeConverter
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $tagList = array('div', 'span');


    /* PUBLIC METHODS
     *************************************************************************/
    public function save($nodeConverterFactory)
    {
        return $this->saveRecursive($nodeConverterFactory);
    }

}