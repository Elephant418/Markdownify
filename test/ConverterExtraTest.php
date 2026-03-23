<?php

namespace Test\Markdownify;

use Markdownify\ConverterExtra;
use PHPUnit\Framework\Attributes\DataProvider;

require_once(__DIR__ . '/../vendor/autoload.php');

class ConverterExtraTest extends ConverterTestCase
{


    /* UTILS
     *************************************************************************/
    protected function setUp(): void
    {
        $this->converter = new ConverterExtra;
    }


    /* HEADING TEST METHODS
     *************************************************************************/
    #[DataProvider('providerHeadingConversion')]
    public function testHeadingConversion_withAttribute($level, $attributesHTML, $attributesMD = null)
    {
        $innerHTML = 'Heading ' . $level;
        $md = str_pad('', $level, '#') . ' ' . $innerHTML . $attributesMD;
        $html = '<h' . $level . $attributesHTML . '>' . $innerHTML . '</h' . $level . '>';
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public static function providerHeadingConversion()
    {
        $attributes = [' id="idAttribute"', ' class=" class1  class2 "'];
        $data = [];
        for ($i = 1; $i <= 6; $i++) {
            $data[] = [$i, '', ''];
            $data[] = [$i, $attributes[0], ' {#idAttribute}'];
            $data[] = [$i, $attributes[1], ' {.class1.class2}'];
            $data[] = [$i, $attributes[0] . $attributes[1], ' {#idAttribute.class1.class2}'];
        }
        return $data;
    }

    public function testHeadingConversionWithoutCssClassOutput()
    {
        $this->converter->setAddCssClass(false);
        $html = '<h1 id="idAttribute" class=" class1  class2 ">Heading 1</h1>';
        $this->assertEquals('# Heading 1', $this->converter->parseString($html));
    }


    /* LINK TEST METHODS
     *************************************************************************/
    public static function providerLinkConversion()
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

    public function testLinkConversionWithoutCssClassOutput()
    {
        $this->converter->setAddCssClass(false);
        $html = '<p>This is <a href="http://example.com/" title="Title" class=" class1  class2 " id="myLink">an example</a> inline link.</p>';
        $md = 'This is [an example][1] inline link.' . PHP_EOL
            . PHP_EOL
            . ' [1]: http://example.com/ "Title"';
        $this->assertEquals($md, $this->converter->parseString($html));
    }


    /* TABLE TEST METHODS
     *************************************************************************/
    public function testTableConversion()
    {
        $html = <<<EOF
<table>
<thead>
<tr>
  <th>First Header</th>
  <th>Second Header</th>
</tr>
</thead>
<tbody>
<tr>
  <td>Content Cell</td>
  <td>Content Cell</td>
</tr>
<tr>
  <td> </td>
  <td>Content Cell</td>
</tr>
</tbody>
</table>
EOF;
        $md = <<<EOF
| First Header | Second Header |
| ------------ | ------------- |
| Content Cell | Content Cell  |
|              | Content Cell  |
EOF;
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public function testTableConversionWithEmptyCell()
    {
        $html = <<<EOF
<table>
<thead>
<tr>
  <th>First Header</th>
  <th>Second Header</th>
</tr>
</thead>
<tbody>
<tr>
  <td>Content Cell</td>
  <td>Content Cell</td>
</tr>
<tr>
  <td></td>
  <td>Content Cell</td>
</tr>
</tbody>
</table>
EOF;
        $md = <<<EOF
| First Header | Second Header |
| ------------ | ------------- |
| Content Cell | Content Cell  |
|              | Content Cell  |
EOF;
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public function testTableConversionWithoutHeaderCells()
    {
        $this->converter->setKeepHTML(false);
        $html = <<<EOF
<table>
<tr>
  <td>January</td>
  <td>42</td>
</tr>
<tr>
  <td>February</td>
  <td>51</td>
</tr>
<tr>
  <td>March</td>
  <td>39</td>
</tr>
</table>
EOF;
        $md = <<<EOF
|          |    |
| -------- | -- |
| January  | 42 |
| February | 51 |
| March    | 39 |
EOF;
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public function testTableConversionWithoutHeaderCellsKeepingHtml()
    {
        $this->converter->setKeepHTML(true);
        $html = <<<EOF
<table>
<tr>
  <td>January</td>
  <td>42</td>
</tr>
<tr>
  <td>February</td>
  <td>51</td>
</tr>
<tr>
  <td>March</td>
  <td>39</td>
</tr>
</table>
EOF;
        $md = <<<EOF
<table>
  <tr>
    <td>
      January
    </td>
    
    <td>
      42
    </td>
  </tr>
  
  <tr>
    <td>
      February
    </td>
    
    <td>
      51
    </td>
  </tr>
  
  <tr>
    <td>
      March
    </td>
    
    <td>
      39
    </td>
  </tr>
</table>
EOF;
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public function testTableConversionWithoutHeaderCellsWithThreeColumns()
    {
        $this->converter->setKeepHTML(false);
        $html = <<<EOF
<table>
<tr>
  <td>One</td>
  <td>Two</td>
  <td>Three</td>
</tr>
<tr>
  <td>Alpha</td>
  <td>Beta</td>
  <td>Gamma</td>
</tr>
</table>
EOF;
        $md = <<<EOF
|       |      |       |
| ----- | ---- | ----- |
| One   | Two  | Three |
| Alpha | Beta | Gamma |
EOF;
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public function testTableConversionWithRowHeadersButWithoutTopHeaderRow()
    {
        $this->converter->setKeepHTML(false);
        $html = <<<EOF
<table>
<tr>
  <th>January</th>
  <td>42</td>
</tr>
<tr>
  <th>February</th>
  <td>51</td>
</tr>
<tr>
  <th>March</th>
  <td>39</td>
</tr>
</table>
EOF;
        $md = <<<EOF
|          |    |
| -------- | -- |
| January  | 42 |
| February | 51 |
| March    | 39 |
EOF;
        $this->assertEquals($md, $this->converter->parseString($html));
    }

    public function testTableConversionWithRowHeadersAndTopHeaderRow()
    {
        $this->converter->setKeepHTML(false);
        $html = <<<EOF
<table>
<tr>
  <th></th>
  <th>Sales</th>
</tr>
<tr>
  <th>January</th>
  <td>42</td>
</tr>
<tr>
  <th>February</th>
  <td>51</td>
</tr>
<tr>
  <th>March</th>
  <td>39</td>
</tr>
</table>
EOF;
        $md = <<<EOF
|          | Sales |
| -------- | ----- |
| January  | 42    |
| February | 51    |
| March    | 39    |
EOF;
        $this->assertEquals($md, $this->converter->parseString($html));
    }
}
