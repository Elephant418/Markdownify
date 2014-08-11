<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\MarkdownConverter;

use \Markdownify\Converter\NodeConverter;

class TransparentMarkdownConverter extends NodeConverter
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $tagList = array('div', 'span');

}