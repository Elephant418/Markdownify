<?php

/* This file is part of the Markdownify 3 project, which is under MIT license */

namespace Markdownify\Markdown\Node;

use \Markdownify\Converter\Node;

class TransparentMarkdownNode extends Node
{

    /* ATTRIBUTES
     *************************************************************************/
    protected $tagList = array('div', 'span');

}