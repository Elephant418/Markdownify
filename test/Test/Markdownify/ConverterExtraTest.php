<?php

/* This file is part of the Markdownify project, which is under LGPL license */

namespace Test\Markdownify;

use Markdownify\ConverterExtra;

require_once(__DIR__ . '/../../../vendor/autoload.php');

class ConverterExtraTest extends \PHPUnit_Framework_TestCase
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


    /* HEADING TEST METHODS
     *************************************************************************/
    /**
     * @dataProvider providerHeadingConversion
     */
    public function testHeadingConversion($level, $attributes=array())
    {
        $innerHTML = 'Heading '.$level;
        $md = str_pad('', $level, '#').' '.$innerHTML;
        $html = '<h'.$level.'>'.$innerHTML.'</h'.$level.'>';
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    /**
     * @dataProvider providerHeadingConversion
     */
    public function testHeadingConversion_withIdAttribute($level)
    {
        $innerHTML = 'Heading '.$level;
        $md = str_pad('', $level, '#').' '.$innerHTML.' {#idAttribute}';
        $html = '<h'.$level.' id="idAttribute">'.$innerHTML.'</h'.$level.'>';
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