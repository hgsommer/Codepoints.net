<?php

namespace Codepoints\Controller;

use Codepoints\Controller;
use Codepoints\Unicode\Codepoint;
use Codepoints\View;
use Exception;


class NotFound extends Controller {

    public function __invoke($match, array $env) : string {
        $title = __('Page not Found');
        $page_description = __('There is no content on this page.');
        $codepoint = null;
        $block = null;
        $plane = null;

        if (preg_match('/^U\+([0-9A-Fa-f]+)$/', $match, $match2)) {
            $cp = hexdec($match2[1]);
            $title = sprintf(__('Codepoint U+%04X not Found'), $cp);
            $page_description = sprintf(__('The point U+%04X is no valid Unicode codepoint.'), $cp);
            $codepoint = new Codepoint([
                'cp' => $cp,
                'name' => $cp <= 0x10FFFF? '<reserved>' : 'CECI N’EST PAS UNICODE',
                'gc' => $cp <= 0x10FFFF? 'Cn' : 'Xx'],
                $env['db']);
            try {
                $block = $codepoint->block;
            } catch (Exception $e) {}
            try {
                $plane = $codepoint->plane;
            } catch (Exception $e) {}
        }

        $this->context += [
            'title' => $title,
            'page_description' => $page_description,
            'codepoint' => $codepoint,
            'prev' => $codepoint? $codepoint->prev : null,
            'next' => $codepoint? $codepoint->next : null,
            'block' => $block,
            'plane' => $plane,
        ];
        $view = $codepoint? 'codepoint' : '404';
        return (new View($view))($this->context, $env);
    }

}
