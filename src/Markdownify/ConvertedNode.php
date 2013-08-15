<?php

/* This file is part of the Markdownify project, which is under LGPL license */

namespace Markdownify;

class ConvertedNode
{



    /* ATTRIBUTES
     *************************************************************************/
    public $startingText;
    public $endingText;
    public $footNotes;
    public $childNodes = array();



    /* PUBLIC METHODS
     *************************************************************************/
    public function getFootNotes() {
        $footNotes = '';
        foreach ($this->childNodes as $childNode) {
            $footNotes .= $childNode->getFootNotes();
        }
        return $footNotes . $this->footNotes;
    }

    public function compile() {
        $compiled = $this->compileNode();

        return $compiled . $this->getFootNotes();
    }



    /* PROTECTED METHODS
     *************************************************************************/
    protected function compileNode() {
        $compiled = '';
        foreach ($this->childNodes as $childNode) {
            $compiled .= $childNode->compileNode();
        }
        return $this->startingText . $compiled . $this->endingText;
    }
}
