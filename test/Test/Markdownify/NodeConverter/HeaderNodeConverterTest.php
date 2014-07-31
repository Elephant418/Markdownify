<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Test\Markdownify;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use Markdownify\Converter;

class HeaderNodeConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerEveryTagLevel
     */
    public function testSimpleTag($level)
    {
        $innerHTML = 'Heading '.$level;
        $html = '<h'.$level.'>'.$innerHTML.'</h'.$level.'>';
        $expected = str_pad('', $level, '#').' '.$innerHTML.PHP_EOL.PHP_EOL;
        
        $actual = (new Converter)->load($html)->save();
        $this->assertEquals($actual, $expected);
    }

    /**
     * @dataProvider providerEveryTagLevel
     */
    public function testHeadingConversionEscape($level)
    {
        $innerHTML = 'Heading '.$level;
        $html = str_pad('', $level, '#').' '.$innerHTML;
        $expected = '\\'.$html.PHP_EOL.PHP_EOL;

        $actual = (new Converter)->load($html)->save();
        $this->assertEquals($actual, $expected);
    }

    public function providerEveryTagLevel()
    {
        $data = array();
        for ($i=1; $i<=6; $i++) {
            $data[] = array($i);
        }
        return $data;
    }

}