<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Test\Markdownify;

require_once(__DIR__ . '/../../vendor/autoload.php');

use Markdownify\MarkdownConverter as Converter;

class HeaderMarkdownConverterTest extends \PHPUnit_Framework_TestCase
{

    /* TEST CASES
     *************************************************************************/
    
    /**
     * @dataProvider providerEveryTagLevel
     */
    public function testSimpleTag($level)
    {
        $label = 'Heading '.$level;
        $html = '<h'.$level.'>'.$label.'</h'.$level.'>';
        $markdown = str_pad('', $level, '#').' '.$label;

        $this->assertMarkdown($markdown, $html);
    }

    /**
     * @dataProvider providerEveryTagLevel
     */
    public function testHashHeadingEscaping($level)
    {
        $label = 'Heading '.$level;
        $html = str_pad('', $level, '#').' '.$label;
        $markdown = '\\'.$html;

        $this->assertMarkdown($markdown, $html);
    }

    public function providerEveryTagLevel()
    {
        $data = array();
        for ($i=1; $i<=6; $i++) {
            $data[] = array($i);
        }
        return $data;
    }


    /**
     * @dataProvider providerDash
     */
    public function testDashHeadingEscaping($dash, $shouldBeEscaped)
    {
        $label = 'Heading 1';
        $html = $label.PHP_EOL
            .$dash.PHP_EOL;
        if ($shouldBeEscaped) {
            $markdown = $label.PHP_EOL
                .'\\'.$dash.PHP_EOL;
        } else {
            $markdown = $html;
        }
        
        $this->assertMarkdown($markdown, $html);
    }

    public function providerDash()
    {
        $data = array();
        foreach (array('=', '-') as $dashType) {
            for ($dashLength=1; $dashLength<=6; $dashLength++) {
                $data[] = array(str_repeat($dashType, $dashLength), ($dashLength >= 3));
            }
        }
        return $data;
    }

    
    /* PROTECTED METHODS
     *************************************************************************/
    protected function assertMarkdown($markdown, $html)
    {
        $markdown .= PHP_EOL.PHP_EOL;
        $converter = new Converter();
        $actual = $converter->load($html)->save();
        $this->assertEquals($markdown, $actual);
    }

}