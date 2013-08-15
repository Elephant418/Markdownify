<?php

require (__DIR__.'/../../../vendor/autoload.php');

$html = '<div><blockquote>blockquoted text goes here <em>coco</em></blockquote>

<blockquote>blockquoted text

 goes here <em>coco</em></blockquote></div>';

$converter = new \Markdownify\Converter();
echo $converter->convert($html);