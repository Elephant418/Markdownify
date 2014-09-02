<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify;

use \Markdownify\Converter\DocumentConverter;

class Converter
{


    /* ATTRIBUTES
     *************************************************************************/
    protected $rootNode = null;
    protected $options;


    /* CONSTRUCTOR METHODS
     *************************************************************************/
    public function __construct($options = array())
    {
        // TODO: options, include Extra converter
    }


    /* PUBLIC METHODS
     *************************************************************************/
    public function load($html)
    {
        $document = new \DOMDocument();
        $document->loadHTML($html);
        $rootNode = new DocumentConverter();
        $this->rootNode = $rootNode->loadDocument($document);
        return $this;
    }

    public function loadFile($file)
    {
        return $this->load(file_get_contents($file));
    }

    public function save()
    {
        
        return $this->rootNode->save($this->getNodeConverterClassList());
    }

    public function getNodeConverterClassList()
    {
        $nodeConverterList = array(
            'Converter\\RootNode',
            'Converter\\TextNode'
        );
        array_walk($nodeConverterList, function(&$item){
            $item = str_replace('Converter\\', 'Markdownify\\Converter\\NodeConverter\\', $item);
        });
        return $nodeConverterList;
    }
}
