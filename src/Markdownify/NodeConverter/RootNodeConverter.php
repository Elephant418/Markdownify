<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\NodeConverter;

class RootNodeConverter extends TransparentNodeConverter
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $tagList = array('html', 'body');


    /* PUBLIC METHODS
     *************************************************************************/
    public function loadDocument(\DOMDocument $document)
    {
        $bodyNode = $this->getBodyNodeFromDocument($document);
        $this->load($bodyNode);
        return $this;
    }


    /* PROTECTED METHODS
     *************************************************************************/
    protected function getBodyNodeFromDocument(\DOMDocument $document)
    {
        $bodyElements = $document->getElementsByTagName('body');
        return $bodyElements->item(0);
    }

}