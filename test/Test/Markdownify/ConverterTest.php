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


    /* HEADING TEST METHODS
     *************************************************************************/
    /**
     * @dataProvider providerHeadingConversion
     */
    public function testHeadingConversionGeneric($level, $attributes=array())
    {
        $innerHTML = 'Heading '.$level;
        $md = str_pad('', $level, '#').' '.$innerHTML;
        $html = '<h'.$level.'>'.$innerHTML.'</h'.$level.'>';
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    /**
     * @dataProvider providerHeadingConversion
     */
    public function testHeadingConversionGeneric_withIdAttribute($level)
    {
        $innerHTML = 'Heading '.$level;
        $attributesHTML = ' id="idAttribute"';
        $md = '<h'.$level.' '.$attributesHTML.'>'.PHP_EOL
            .'  '.$innerHTML.PHP_EOL
            .'</h'.$level.'>';
        $html = '<h'.$level.' '.$attributesHTML.'>'.$innerHTML.'</h'.$level.'>';
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public function providerHeadingConversion()
    {
        return array(
            array(1),
            array(2),
            array(3),
            array(4),
            array(5),
            array(6)
        );
    }
}