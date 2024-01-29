<?php

namespace view;
use \IDisplay;

class HtmlElement implements IDisplay {
    function __construct(
        public string $tag,
        public string $text = "",
    ) {}

    public function display(): string {
        $escape = fn($s) => htmlEntities($s, ENT_QUOTES);
        $text = $escape($this->text);
        $tag = $escape($this->tag);
        return "<{$tag}>{$text}</{$tag}>";
    }
}
