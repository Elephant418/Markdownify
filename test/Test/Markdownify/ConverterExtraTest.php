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
        $attributesHTML = '';
        $md = str_pad('', $level, '#').' '.$innerHTML;

        // If there is an id, ConverterExtra will convert it
        if (isset($attributes['id'])){
            $md .= ' {#'.$attributes['id'].'}';
            $attributesHTML .= ' id="'.$attributes['id'].'"';
        }
        $html = '<h'.$level.' '.$attributesHTML.'>'.$innerHTML.'</h'.$level.'>';
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public function providerHeadingConversion()
    {
        return array(
            array(1),
            array(1, array('id' => 'idAttribute')),
            array(2),
            array(2, array('id' => 'idAttribute')),
            array(3),
            array(3, array('id' => 'idAttribute')),
            array(4),
            array(4, array('id' => 'idAttribute')),
            array(5),
            array(5, array('id' => 'idAttribute')),
            array(6),
            array(6, array('id' => 'idAttribute'))
        );
    }
}