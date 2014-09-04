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
    
    public function testLineBreaksEscaping()
    {
        $label = 'HTML text with line breaks';
        $html = '<p>'.$label.PHP_EOL.PHP_EOL.$label.'</p>';
        $markdown = $label.PHP_EOL.$label;

        $this->assertMarkdown($markdown, $html);
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