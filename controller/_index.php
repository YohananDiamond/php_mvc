<?php

use \view\SamplePage;
use \view\HtmlElement;

class Page {
    static function main(): Response {
        return new Response(
            body: new SamplePage(
                title: "Example page (página de exemplo)",
                body: new HtmlElement("p", text: "Lorem ipsum dolor sit amet"),
            ),
        );
    }
}
