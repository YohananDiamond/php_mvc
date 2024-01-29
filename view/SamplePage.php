<?php

namespace view;
use \IDisplay;

class SamplePage implements IDisplay {
    function __construct(
        public string $title,
        public IDisplay $body,
    ) {}

    public function display(): string {
        $escape = fn($s) => htmlEntities($s, ENT_QUOTES);
        $title = $escape($this->title);
        $body = $this->body->display();

        return <<<EOF
<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>
</head>
<body>
    <h1>{$title}</h1>
    {$body}
</body>
</html>
EOF;
    }
}
