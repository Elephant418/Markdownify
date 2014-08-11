<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\Converter;

class Document extends Node
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $tagList = array();


    /* PUBLIC METHODS
     *************************************************************************/
    public function loadDocument(\DOMDocument $document)
    {
        return $this->load($document->documentElement);
    }

}