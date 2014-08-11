<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\Converter;

interface NodeInterface
{

    public function __construct();

    public function canHandleNode(\DOMNode $node);

    public function load(\DOMNode $node);

    public function save($nodeConverterClassList);
    
    public function escapeText($text);
}