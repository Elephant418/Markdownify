<?php

/* This file is part of the Markdownify project, which is under LGPL license */

namespace Test\Markdownify;

use Markdownify\ConverterExtra;

require_once(__DIR__ . '/../../../vendor/autoload.php');

class ConverterExtraTest extends ConverterTest
{


    /* ATTRIBUTES
     *************************************************************************/
    protected $converter;


    /* UTILS
     *************************************************************************/
    public function setUp()
    {
        $this->converter = new ConverterExtra;
    }


    /* TEST METHODS
     *************************************************************************/
    public function testHeadingConversion_withAnchor()
    {
        $this->assertEquals('# Heading1 {#anchor}', $this->converter->parseString('<h1 id="anchor">Heading1</h1>'));
    }
}