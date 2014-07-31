<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\NodeConverter;

class InlineNodeConverter extends \Markdownify\NodeConverter
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $prefix = '';
    protected $suffix = '';
    protected $lineBreaks = 1;


    /* PUBLIC METHODS
     *************************************************************************/
    public function save($nodeConverterClassList)
    {
        $this->initialization();
        $export = $this->prefix.$this->getEscapedText($nodeConverterClassList).$this->suffix;
        $export .= str_repeat("\n", $this->lineBreaks);
        return $export;
    }


    /* PROTECTED METHODS
     *************************************************************************/
    protected function initialization()
    {
    }
    
    protected function getEscapedText($nodeConverterClassList) {
        $text = $this->node->textContent;
        foreach ($nodeConverterClassList as $nodeConverterClass) {
            $nodeConverterClass = 'Markdownify\\NodeConverter\\' . $nodeConverterClass;
            $nodeConverter = new $nodeConverterClass;
            $text = $nodeConverter->escapeText($text);
        }
        return $text;
    }
    
    protected function setLineBreaks($number)
    {
        $this->lineBreaks = $number;
        return $this;
    }
    
    protected function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    protected function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }

    protected function setWrapper($wrapper)
    {
        $this->prefix = $wrapper;
        $this->suffix = $wrapper;
        return $this;
    }

}