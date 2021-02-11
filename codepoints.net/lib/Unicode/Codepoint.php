<?php

namespace Codepoints\Unicode;

use \Codepoints\Unicode\Block;
use \Codepoints\Database;


/**
 * a single Unicode code point
 */
class Codepoint {

    /**
     * the Unicode code point as integer
     */
    private int $id;

    /**
     * the official name
     *
     * Possibly some other value, like na1 field or a correction from the
     * aliases list.
     */
    private string $name;

    private Database $db;

    /**
     * the previous code point or false for U+0000
     */
    private $prev = null;

    /**
     * the next code point or false for U+10FFFF
     */
    private $next = null;

    private static Array $instance_cache = [];

    private static Array $info_providers = [];
    private Array $info_cache = [];

    public function __construct(Array $data, Database $db) {
        $this->id = $data['cp'];
        $this->name = $data['name'];
        $this->db = $db;
    }

    /**
     * get the official Unicode ID in the form U+[hex]{4,6}
     */
    public function __toString() : string {
        return sprintf('U+%04X', $this->id);
    }

    /**
     * allow read access to our data
     */
    public function __get(string $name) {
        switch ($name) {
        case 'id':
            return $this->id;
        case 'name':
            return $this->name;
        case 'prev':
            return $this->getPrev();
        case 'next':
            return $this->getNext();
        case 'block':
            return Block::getByCodepoint($this, $this->db);
        }
    }

    /**
     * get a safe, printable representation
     *
     * Some control characters have dedicated representations. We use those,
     * e.g., U+0000 => U+2400.
     * /
    public function chr() : string {
        if ($this->id < 0x21) {
            return mb_chr($this->id + 0x2400);
        } elseif ($this->id === 0x7F) { // U+007F DELETE
            return mb_chr(0x2421);
        } elseif (substr($this->gc, 0, 1) === 'C') {
            return mb_chr(0xFFFD);
        }
        return mb_chr($this->id);
    }
     */

    /**
     * get a bit of information about this code point from a registered
     * info source
     *
     * @see self::addInfoProvider
     */
    public function getInfo(string $name, ...$args) {
        if (! array_key_exists($name, $this->info_cache)) {
            if (! array_key_exists($name, static::$info_providers)) {
                return null;
            }
            $this->info_cache[$name] = static::$info_providers[$name]($this, $args);
        }
        return $this->info_cache[$name];
    }

    /**
     * get the previous codepoint
     */
    private function getPrev() /*: self|false */ {
        if ($this->prev === null) {
            $this->prev = false;
            $other = $this->db->getOne('SELECT cp, name FROM codepoints
                WHERE cp < ?
                ORDER BY cp DESC
                LIMIT 1', $this->id);
            if ($other) {
                $this->prev = self::getCached($other, $this->db);
            }
        }
        return $this->prev;
    }

    /**
     * get the next codepoint
     */
    private function getNext() /*: self|false */ {
        if ($this->next === null) {
            $this->next = false;
            $other = $this->db->getOne('SELECT cp, name FROM codepoints
                WHERE cp > ?
                ORDER BY cp ASC
                LIMIT 1', $this->id);
            if ($other) {
                $this->next = self::getCached($other, $this->db);
            }
        }
        return $this->next;
    }

    /**
     * static function: get a cached Codepoint instance, if it exists
     */
    public static function getCached(Array $data, Database $db) : self {
        $cp = $data['cp'];
        if (! array_key_exists($cp, self::$instance_cache)) {
            self::$instance_cache[$cp] = new self($data, $db);
        }
        return self::$instance_cache[$cp];
    }

    /**
     * register an information provider class
     */
    public static function addInfoProvider(string $name, callable $provider) : void {
        static::$info_providers[$name] = $provider;
    }

}
