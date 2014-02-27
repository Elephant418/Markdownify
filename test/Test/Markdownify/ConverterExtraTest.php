<?php

/* This file is part of the Markdownify project, which is under LGPL license */

namespace Test\Markdownify;

use Markdownify\ConverterExtra;

require_once(__DIR__ . '/../../../vendor/autoload.php');

class ConverterExtraTest extends ConverterTestCase
{


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
    public function testHeadingConversion_withIdAttribute($level)
    {
        $innerHTML = 'Heading '.$level;
        $md = str_pad('', $level, '#').' '.$innerHTML.' {#idAttribute}';
        $html = '<h'.$level.' id="idAttribute">'.$innerHTML.'</h'.$level.'>';
        $this->assertEquals($md, $this->converter->parseString($html));
    }


    /* LINK TEST METHODS
     *************************************************************************/
    public function providerLinkConversion()
    {
        $data = parent::providerLinkConversion();

        // Link with href + title + id attributes
        $data['url-title-id']['md'] = 'This is [an example][1]{#myLink} inline link.

 [1]: http://example.com/ "Title"';

        // Link with href + title + class attributes
        $data['url-title-class']['md'] = 'This is [an example][1]{.external} inline link.

 [1]: http://example.com/ "Title"';

        // Link with href + title + multiple classes attributes
        $data['url-title-multiple-class']['md'] = 'This is [an example][1]{.class1.class2} inline link.

 [1]: http://example.com/ "Title"';

        // Link with href + title + multiple classes attributes
        $data['url-title-multiple-class-id']['md'] = 'This is [an example][1]{#myLink.class1.class2} inline link.

 [1]: http://example.com/ "Title"';

        return $data;
    }
}