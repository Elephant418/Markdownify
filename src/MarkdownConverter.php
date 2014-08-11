<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify;

use \Markdownify\NodeConverter\RootNodeConverter;

class MarkdownConverter extends Converter
{
    
    public function getNodeConverterClassList()
    {
        $nodeConverterList = array(
            'Converter\\RootNode',
            'Converter\\TextNode',
            'Markdown\\TransparentMarkdown',
            'Markdown\\HeaderMarkdown',
            'Markdown\\ParagraphMarkdown'
        );
        array_walk($nodeConverterList, function(&$item){
            $item = str_replace('Converter\\', 'Markdownify\\Converter\\NodeConverter\\', $item);
            $item = str_replace('Markdown\\', 'Markdownify\\MarkdownConverter\\', $item);
            $item .= 'Converter';
        });
        return $nodeConverterList;
    }
}
