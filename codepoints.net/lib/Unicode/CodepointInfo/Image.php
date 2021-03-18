<?php

namespace Codepoints\Unicode\CodepointInfo;

use \Codepoints\Database;
use \Codepoints\Unicode\Codepoint;
use \Codepoints\Unicode\CodepointInfo;


/**
 * provide images for a given code point
 */
class Image extends CodepointInfo {

    private string $altText;

    public function __construct(Array $env) {
        /* this is a performance optimation to call __() less */
        $this->altText = __('Glyph for %s');
        parent::__construct($env);
    }

    /**
     * return the image element for a code point
     *
     * When https://bugzilla.mozilla.org/show_bug.cgi?id=1027106 is fixed, we
     * can switch back to good ol' <img> again.
     */
    public function __invoke(Codepoint $codepoint) : callable {
        $altText = $this->altText;
        return function(int $width=16) use ($codepoint, $altText) : string {
            $alt = sprintf($altText, (string)$codepoint);
            if (in_array($codepoint->gc, ['Cn', 'Co', 'Cs', 'Xx'])) {
                return sprintf(
                    '<img src="%s" width="%s" height="%s" alt="%s">',
                    q(url('/static/images/icon.svg')),
                    $width, $width, $alt);
            }
            $id = $codepoint->id;
            if ($id < 0x21) {
                $id = $id + 0x2400;
            } elseif ($id === 0x7F) { // U+007F DELETE
                $id = 0x2421;
            } elseif (substr($codepoint->gc, 0, 1) === 'C') {
                $id = 0xFFFD;
            } elseif ($codepoint->gc === 'Zl') { // new line => symbol for newline
                $id = 0x2424;
            } elseif ($codepoint->gc === 'Zp') { // new paragraph => pilcrow
                $id = 0x00B6;
            }
            $url = sprintf('image/%04X.svg#U%04X', $id - $id % 0x100, $id);
            $modifier = '';
            if (in_array($codepoint->gc, ['Mn', 'Me', 'Lm', 'Sk'])) {
                /* for combining characters, add the U+25CC circle */
                $modifier = '<use xlink:href="image/2500.svg#U25CC" fill-opacity="0.25"/>';
            }
            return sprintf('<svg width="%s" height="%s">'.
                '<title>%s</title>'.
                '%s<use xlink:href="%s"/></svg>', $width, $width, $alt, $modifier, $url);
        };
    }

}
