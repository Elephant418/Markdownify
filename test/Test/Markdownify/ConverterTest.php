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


    /* ESCAPE TEST METHODS
     *************************************************************************/

    /**
     * @dataProvider providerAutoescapeConversion
     */
    public function testAutoescapeConversion($html)
    {
        $this->assertEquals(html_entity_decode($html), $this->converter->parseString($html));
    }

    public function providerAutoescapeConversion()
    {
        return array(
            array('AT&amp;T'),
            array('4 &lt; 5'),
            array('&copy;')
        );
    }


    /* BLOCKQUOTE TEST METHODS
     *************************************************************************/

    /**
     * @dataProvider providerBlockquoteConversion
     */
    public function testBlockquoteConversion($html, $md)
    {
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public function providerBlockquoteConversion()
    {
        $data = array();
        $data['simple']['html'] = '<blockquote>blockquoted text goes here</blockquote>';
        $data['simple']['md'] = '> blockquoted text goes here';
        $data['paragraphs']['html'] = '<blockquote><p>paragraph1</p><p>paragraph2</p></blockquote>';
        $data['paragraphs']['md'] = '> paragraph1
> 
> paragraph2';
        $data['cascade']['html'] = '<blockquote><blockquote>cascading blockquote</blockquote></blockquote>';
        $data['cascade']['md'] = '> > cascading blockquote';
        $data['container']['html'] = '<blockquote><h2>This is a header.</h2></blockquote>';
        $data['container']['md'] = '> ## This is a header.';
        return $data;
    }

}