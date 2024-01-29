<?php

class Response {
    function __construct(
        public string|IDisplay $body,
        public int $code = 200,
    ) {}
}
