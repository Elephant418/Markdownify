<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify;

class NodeConverterFactory
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $nodeConverterClassList = array();


    /* CONSTRUCTOR METHODS
     *************************************************************************/
    public function __construct($nodeConverterClassList)
    {
        $this->nodeConverterClassList = $nodeConverterClassList;
    }


    /* PUBLIC METHODS
     *************************************************************************/
    public function instanceNodeConverter(\DOMNode $node)
    {
        foreach ($this->nodeConverterClassList as $nodeConverterClass) {
            $nodeConverterClass = 'Markdownify\\NodeConverter\\' . $nodeConverterClass;
            $nodeConverter = new $nodeConverterClass;
            if ($nodeConverter->canHandleNode($node)) {
                return $nodeConverter->load($node);
            }
        }
        return null;
    }
}


