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
    public function testHeadingConversion_Level1()
    {
        echo get_class($this).PHP_EOL;
        $this->_testHeadingConversionGeneric(1);
    }
    
    public function testHeadingConversion_Level1_withId()
    {
        $this->_testHeadingConversionGeneric(1, array('id' => 'idAttribute'));
    }
    
    public function testHeadingConversion_Level2()
    {
        $this->_testHeadingConversionGeneric(2);
    }

    public function testHeadingConversion_Level2_withId()
    {
        $this->_testHeadingConversionGeneric(2, array('id' => 'idAttribute'));
    }

    public function testHeadingConversion_Level3()
    {
        $this->_testHeadingConversionGeneric(3);
    }

    public function testHeadingConversion_Level3_withId()
    {
        $this->_testHeadingConversionGeneric(3, array('id' => 'idAttribute'));
    }

    public function testHeadingConversion_Level4()
    {
        $this->_testHeadingConversionGeneric(4);
    }

    public function testHeadingConversion_Level4_withId()
    {
        $this->_testHeadingConversionGeneric(4, array('id' => 'idAttribute'));
    }

    public function testHeadingConversion_Level5()
    {
        $this->_testHeadingConversionGeneric(5);
    }

    public function testHeadingConversion_Level5_withId()
    {
        $this->_testHeadingConversionGeneric(5, array('id' => 'idAttribute'));
    }

    public function testHeadingConversion_Level6()
    {
        $this->_testHeadingConversionGeneric(6);
    }

    public function testHeadingConversion_Level6_withId()
    {
        $this->_testHeadingConversionGeneric(6, array('id' => 'idAttribute'));
    }

    protected function _testHeadingConversionGeneric($level, $attributes=array())
    {
        $innerHTML = 'Heading '.$level;
        $attributesHTML = '';
        if (isset($attributes['id'])){
            $attributesHTML .= ' id="'.$attributes['id'].'"';
            $md = '<h'.$level.' '.$attributesHTML.'>'.PHP_EOL.'  '.$innerHTML.PHP_EOL.'</h'.$level.'>';
        } else {
            $md = str_pad('', $level, '#').' '.$innerHTML;
        }
        $html = '<h'.$level.' '.$attributesHTML.'>'.$innerHTML.'</h'.$level.'>';
        $this->assertEquals($md, $this->converter->parseString($html));
    }
}