<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Test\Markdownify;

require_once(__DIR__ . '/../../vendor/autoload.php');

use Markdownify\MarkdownConverter as Converter;

class HeaderNodeConverterTest extends \PHPUnit_Framework_TestCase
{

    /* TEST CASES
     *************************************************************************/
    public function testSimpleTag()
    {
        $label = 'Paragraph';
        $html = '<p>'.$label.'</p>';
        $markdown = $label;

        $this->assertMarkdown($markdown, $html);
    }


    /**
     * @dataProvider providerLineBreaks
     */
    public function testLineBreaksEscaping($lineBreaks)
    {
        $label = 'HTML text with line breaks';
        $html = '<p>'.$label.$lineBreaks.$label.'</p>';
        $markdown = $label.PHP_EOL.$label;

        $this->assertMarkdown($markdown, $html);
    }

    public function providerLineBreaks()
    {
        $data = array();
        for ($lineBreaksCount=1; $lineBreaksCount<=6; $lineBreaksCount++) {
            $data[] = array(str_repeat(PHP_EOL, $lineBreaksCount));
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