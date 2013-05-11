<?php

/* This file is part of the Markdownify project, which is under LGPL license */

namespace Test\Markdownify;

use Markdownify\Converter;

require_once(__DIR__ . '/../../../vendor/autoload.php');

class ConverterTest extends \PHPUnit_Framework_TestCase
{


    /* ATTRIBUTES
     *************************************************************************/
    protected $converter;


    /* UTILS
     *************************************************************************/
    public function setUp()
    {
        $this->converter = new Converter;
    }


    /* TEST METHODS
     *************************************************************************/
    public function testHeadingConversion_Level1()
    {
        $this->assertEquals('# Heading1', $this->converter->parseString('<h1>Heading1</h1>'));
    }
}