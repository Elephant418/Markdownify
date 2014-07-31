<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify;

interface NodeConverterInterface
{

    public function __construct();

    public function load(\DOMNode $node);

    public function save($nodeConverterFactory);
}