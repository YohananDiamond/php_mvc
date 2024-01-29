<?php

require_once(__DIR__ . "/autoload.php");

abstract class _Bootstrap {
    static function main(): void {
        // process request URI
        $request = $_SERVER["REQUEST_URI"];
        $request = strtok($request, "?"); // remove query arguments
        $request = preg_replace('/^\/router_test\//', '', $request);
        $request = preg_replace('/\/$/', '', $request);

        if (preg_match('/^_handlers\//', $request)) self::run404();

        if ($request == "") self::runController("_index");
        else self::runController($request);

        self::run404();
    }

    /**
     * Attempts to run a controller. Stops execution if it succeeded.
     */
    static function runController(string $path): void {
        $controller_dir = __DIR__ . "/controller";
        $p = "{$controller_dir}/{$path}.php";
        if (file_exists($p)) {
            require($p);
            self::handleResponse(Page::main());
        }
    }

    static function run404(): void {
        if (self::runController("_handlers/404")) return;
        self::handleResponse(new Response(
            body: "<h1>Whoops!</h1><p>The requested page does not exist.</p>",
            code: 404,
        ));
    }

    static function handleResponse(Response $response): void {
        http_response_code($response->code);
        echo ($response->body instanceof IDisplay)
            ? $response->body->display()
            : $response->body;
        // TODO: stuff to run after (a closure, I guess...)
        exit();
    }
}

_Bootstrap::main();
