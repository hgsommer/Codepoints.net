<?php

namespace Codepoints\Controller;

use Codepoints\Controller;
use Codepoints\Router\NotFoundException;
use Codepoints\Router\Pagination;
use Codepoints\Unicode\Block as UnicodeBlock;


class Block extends Controller {

    public function __invoke($data, array $env) : string {
        $block = new UnicodeBlock($data, $env['db']);
        $page = (int)filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
        if (! $page) {
            $page = 1;
        }

        /* put correct language first: https://stackoverflow.com/a/27694067/113195 */
        $abstract = $env['db']->getOne('
            SELECT lang, abstract, src
                FROM block_abstract
            WHERE first = ?
                AND (lang = ? OR lang = "en")
            ORDER BY lang = ? DESC
            LIMIT 1', $block->first, $env['lang'], $env['lang']);

        $age = $env['db']->getOne('
            SELECT age
                FROM codepoint_props
            WHERE cp >= ?
                AND cp <= ?
            ORDER BY CAST(age AS FLOAT) DESC
            LIMIT 1');
        if ($age) {
            $age = $age['age'];
        } else {
            $age = '1.0';
        }

        $this->context += [
            'title' => $block->name,
            'page_description' => sprintf(
                __('The Unicode block %s contains the codepoints from U+%04X to U+%04X.'),
                $block->name, $block->first, $block->last),
            'block' => $block,
            'prev' => $block->prev,
            'next' => $block->next,
            'pagination' => new Pagination($block, $page),
            'abstract' => $abstract,
            'age' => $age,
        ];
        return parent::__invoke($data, $env);
    }

}
