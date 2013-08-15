<?php

/* This file is part of the Markdownify project, which is under LGPL license */

namespace Markdownify;

/**
 * default configuration
 */
define('MDFY_LINKS_EACH_PARAGRAPH', false);
define('MDFY_BODYWIDTH', false);
define('MDFY_KEEPHTML', true);

/**
 * HTML to Markdown converter class
 */
class Converter extends AbstractConverter
{

    /**
     * tags with elements which can be handled by markdown
     *
     * @var array<string>
     */
    protected $tagAttributeType = array(
        'p' => array(),
        'ul' => array(),
        'ol' => array(),
        'li' => array(),
        'br' => array(),
        'blockquote' => array(),
        'code' => array(),
        'pre' => array(),
        'a' => array(
            'href' => 'required',
            'title' => 'optional',
        ),
        'strong' => array(),
        'b' => array(),
        'em' => array(),
        'i' => array(),
        'img' => array(
            'src' => 'required',
            'alt' => 'optional',
            'title' => 'optional',
        ),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array(),
        'hr' => array(),
    );

    /**
     * Markdown indents which could be wrapped
     * @note: use strings in regex format
     *
     * @var array<string>
     */
    protected $wrappableIndents = array(
        '\*   ', // ul
        '\d.  ', // ol
        '\d\d. ', // ol
        '> ', // blockquote
        '', // p
    );

    /**
     * list of chars which have to be escaped in normal text
     * @note: use strings in regex format
     *
     * @var array
     *
     * TODO: what's with block chars / sequences at the beginning of a block?
     */
    protected $escapeInText = array(
        '\*\*([^*]+)\*\*' => '\*\*$1\*\*', // strong
        '\*([^*]+)\*' => '\*$1\*', // em
        '__(?! |_)(.+)(?!<_| )__' => '\_\_$1\_\_', // strong
        '_(?! |_)(.+)(?!<_| )_' => '\_$1\_', // em
        '([-*_])([ ]{0,2}\1){2,}' => '\\\\$0', // hr
        '`' => '\`', // code
        '\[(.+)\](\s*\()' => '\[$1\]$2', // links: [text] (url) => [text\] (url)
        '\[(.+)\](\s*)\[(.*)\]' => '\[$1\]$2\[$3\]', // links: [text][id] => [text\][id\]
        '^#(#{0,5}) ' => '\#$1 ', // header
    );



    /* PUBLIC METHODS
     *************************************************************************/
    public function convert($html) {
        $compiledText = parent::convert($html);
        $compiledText = preg_replace("/\n\n+/", "\n\n", $compiledText);
        $compiledText = rtrim($compiledText);
        return $compiledText;
    }



    /* PROTECTED METHODS
     *************************************************************************/

    // TODO: escapeText & remove space + eol in text

    // <em> and <i> tags
    protected function convertElement_em($node, &$convertedNode)
    {
        $convertedNode->startingText = '*';
        $convertedNode->endingText = '*';
    }
    protected function convertElement_i($node, $convertedNode)
    {
        $this->convertElement_em($node, $convertedNode);
    }

    // <strong> and <b> tags
    protected function convertElement_strong($node, &$convertedNode)
    {
        $convertedNode->startingText = '**';
        $convertedNode->endingText = '**';
    }

    protected function convertElement_b($node, &$convertedNode)
    {
        $this->convertElement_strong($node, $convertedNode);
    }

    // <h1> to <h6> tags
    protected function convertElement_h1($node, &$convertedNode)
    {
        $this->convertElement_h($node, $convertedNode, 1);
    }

    protected function convertElement_h2($node, &$convertedNode)
    {
        $this->convertElement_h($node, $convertedNode, 2);
    }

    protected function convertElement_h3($node, &$convertedNode)
    {
        $this->convertElement_h($node, $convertedNode, 3);
    }

    protected function convertElement_h4($node, &$convertedNode)
    {
        $this->convertElement_h($node, $convertedNode, 4);
    }

    protected function convertElement_h5($node, &$convertedNode)
    {
        $this->convertElement_h($node, $convertedNode, 5);
    }

    protected function convertElement_h6($node, &$convertedNode)
    {
        $this->convertElement_h($node, $convertedNode, 6);
    }

    protected function convertElement_h($node, &$convertedNode, $level)
    {
        $convertedNode->startingText = str_repeat('#', $level).' ';
        $convertedNode->endingText = PHP_EOL . PHP_EOL;
    }

    // <p> tags
    protected function convertElement_p($node, &$convertedNode)
    {
        $convertedNode->endingText = PHP_EOL . PHP_EOL;
    }

    // <blockquote> tags
    protected function convertElement_blockquote($node, &$convertedNode)
    {
        $convertedNode->startingText = '> ';
        $convertedNode->endingText = PHP_EOL . PHP_EOL;
    }

    /**
     * handle <a> tags
     *
     * @param void
     * @return void
     */
    protected function handleTag_a()
    {
        if ($this->parser->isStartTag) {
            $this->buffer();
            if (isset($this->parser->tagAttributes['title'])) {
                $this->parser->tagAttributes['title'] = $this->decode($this->parser->tagAttributes['title']);
            } else {
                $this->parser->tagAttributes['title'] = null;
            }
            $this->parser->tagAttributes['href'] = $this->decode(trim($this->parser->tagAttributes['href']));
            $this->stack();
        } else {
            $tag = $this->unstack();
            $buffer = $this->unbuffer();

            // Empty links... testcase mania, who would possibly do anything like that?!
            if (empty($tag['href']) && empty($tag['title'])) {
                $this->out('[' . $buffer . ']()', true);
                return;
            }

            // Example: <http://example.com>
            if ($buffer == $tag['href'] && empty($tag['title'])) {
                $this->out('<' . $buffer . '>', true);
                return;
            }

            // Example: <mail@example.com>
            $bufferDecoded = $this->decode(trim($buffer));
            if (substr($tag['href'], 0, 7) == 'mailto:' && 'mailto:' . $bufferDecoded == $tag['href']) {
                if (is_null($tag['title'])) {
                    $this->out('<' . $bufferDecoded . '>', true);
                    return;
                }
                $tag['href'] = 'mailto:' . $bufferDecoded;
            }

            // Example: [This link][id]
            foreach ($this->stack['a'] as $tag2) {
                if ($tag2['href'] == $tag['href'] && $tag2['title'] === $tag['title']) {
                    $tag['linkID'] = $tag2['linkID'];
                    break;
                }
            }
            if (!isset($tag['linkID'])) {
                $tag['linkID'] = count($this->stack['a']) + 1;
                array_push($this->stack['a'], $tag);
            }

            $this->out('[' . $buffer . '][' . $tag['linkID'] . ']', true);
        }
    }

    /**
     * handle <img /> tags
     *
     * @param void
     * @return void
     */
    protected function handleTag_img()
    {
        if (!$this->parser->isStartTag) {
            return; // Just to be sure this is really an empty tag...
        }

        if (isset($this->parser->tagAttributes['title'])) {
            $this->parser->tagAttributes['title'] = $this->decode($this->parser->tagAttributes['title']);
        } else {
            $this->parser->tagAttributes['title'] = null;
        }
        if (isset($this->parser->tagAttributes['alt'])) {
            $this->parser->tagAttributes['alt'] = $this->decode($this->parser->tagAttributes['alt']);
        } else {
            $this->parser->tagAttributes['alt'] = null;
        }

        if (empty($this->parser->tagAttributes['src'])) {
            // Support for "empty" images... dunno if this is really needed
            // But there are some testcases which do that...
            if (!empty($this->parser->tagAttributes['title'])) {
                $this->parser->tagAttributes['title'] = ' ' . $this->parser->tagAttributes['title'] . ' ';
            }
            $this->out('![' . $this->parser->tagAttributes['alt'] . '](' . $this->parser->tagAttributes['title'] . ')', true);

            return;
        } else {
            $this->parser->tagAttributes['src'] = $this->decode($this->parser->tagAttributes['src']);
        }

        // Example: [This link][id]
        $link_id = false;
        if (!empty($this->stack['a'])) {
            foreach ($this->stack['a'] as $tag) {
                if ($tag['href'] == $this->parser->tagAttributes['src']
                    && $tag['title'] === $this->parser->tagAttributes['title']
                ) {
                    $link_id = $tag['linkID'];
                    break;
                }
            }
        } else {
            $this->stack['a'] = array();
        }
        if (!$link_id) {
            $link_id = count($this->stack['a']) + 1;
            $tag = array(
                'href' => $this->parser->tagAttributes['src'],
                'linkID' => $link_id,
                'title' => $this->parser->tagAttributes['title']
            );
            array_push($this->stack['a'], $tag);
        }

        $this->out('![' . $this->parser->tagAttributes['alt'] . '][' . $link_id . ']', true);
    }

    /**
     * handle <code> tags
     *
     * @param void
     * @return void
     */
    protected function handleTag_code()
    {
        // Ignore code blocks inside <pre>
        if ($this->hasParent('pre')) {
            return;
        }
        if ($this->parser->isStartTag) {
            $this->buffer();
        } else {
            $buffer = $this->unbuffer();
            // Use as many backticks as needed
            preg_match_all('#`+#', $buffer, $matches);
            if (!empty($matches[0])) {
                rsort($matches[0]);

                $ticks = '`';
                while (true) {
                    if (!in_array($ticks, $matches[0])) {
                        break;
                    }
                    $ticks .= '`';
                }
            } else {
                $ticks = '`';
            }
            if ($buffer[0] == '`' || substr($buffer, -1) == '`') {
                $buffer = ' ' . $buffer . ' ';
            }
            $this->out($ticks . $buffer . $ticks, true);
        }
    }

    /**
     * handle <pre> tags
     *
     * @param void
     * @return void
     */
    protected function handleTag_pre()
    {
        if ($this->keepHTML && $this->parser->isStartTag) {
            // Check if a simple <code> follows
            if (!preg_match('#^\s*<code\s*>#Us', $this->parser->html)) {
                // This is no standard markdown code block
                $this->handleTagToText();

                return;
            }
        }
        $this->indent('    ');
        if (!$this->parser->isStartTag) {
            $this->setLineBreaks(2);
        } else {
            $this->parser->html = ltrim($this->parser->html);
        }
    }

    /**
     * handle <ul> tags
     *
     * @param void
     * @return void
     */
    protected function handleTag_ul()
    {
        if ($this->parser->isStartTag) {
            $this->stack();
            if (!$this->keepHTML && $this->lastClosedTag == $this->parser->tagName) {
                $this->out("\n" . $this->indent . '<!-- -->' . "\n" . $this->indent . "\n" . $this->indent);
            }
        } else {
            $this->unstack();
            if ($this->parent() != 'li' || preg_match('#^\s*(</li\s*>\s*<li\s*>\s*)?<(p|blockquote)\s*>#sU', $this->parser->html)) {
                // Dont make Markdown add unneeded paragraphs
                $this->setLineBreaks(2);
            }
        }
    }

    /**
     * handle <ul> tags
     *
     * @param void
     * @return void
     */
    protected function handleTag_ol()
    {
        // Same as above
        $this->parser->tagAttributes['num'] = 0;
        $this->handleTag_ul();
    }

    /**
     * handle <li> tags
     *
     * @param void
     * @return void
     */
    protected function handleTag_li()
    {
        if ($this->parent() == 'ol') {
            $parent =& $this->getStacked('ol');
            if ($this->parser->isStartTag) {
                $parent['num']++;
                $this->out($parent['num'] . '.' . str_repeat(' ', 3 - strlen($parent['num'])), true);
            }
            $this->indent('    ', false);
        } else {
            if ($this->parser->isStartTag) {
                $this->out('*   ', true);
            }
            $this->indent('    ', false);
        }
        if (!$this->parser->isStartTag) {
            $this->setLineBreaks(1);
        }
    }

    /**
     * handle <hr /> tags
     *
     * @param void
     * @return void
     */
    protected function handleTag_hr()
    {
        // Just to be sure this really is an empty tag
        if (!$this->parser->isStartTag) {
            return;
        }
        $this->out('* * *', true);
        $this->setLineBreaks(2);
    }

    /**
     * handle <br /> tags
     *
     * @param void
     * @return void
     */
    protected function handleTag_br()
    {
        $this->out("  \n" . $this->indent, true);
        $this->parser->html = ltrim($this->parser->html);
    }
}
