<?php

require_once(__DIR__ . "/autoload.php");

#[Attribute]
class Route {
    function __construct(public string $path) {}
}

#[Attribute]
class SpecialRoute {
    function __construct(public string $id) {}
}


class Response {
    function __construct(
        public string $body,
        public int $code = 200,
    ) {}
}

// process request URI
$request = $_SERVER["REQUEST_URI"];
$request = strtok($request, "?"); // remove query arguments
$request = preg_replace('/^\/router_test\//', '', $request);
$request = preg_replace('/\/$/', '', $request);
$request = preg_replace('/^(\/)*/', '/', $request);

/*
 * Attempts to run a controller. Returns whether it succeeded.
 */
// function runController($path): bool {
//     $controller_dir = __DIR__ . "/controller";
// }

// function main()

// if ($request == )

// if (runController())

use controller\MainRouter;

$rc = new ReflectionClass(MainRouter::class);

$spr_404 = null;
$routes = [];
$methods = $rc->getMethods(ReflectionMethod::IS_STATIC | ReflectionMethod::IS_PUBLIC);
foreach ($methods as $m) {
    $is_special_route = false;
    $route = null;
    foreach ($m->getAttributes() as $attr) {
        $attr = $attr->newInstance();
        if ($attr instanceof Route) {
            $route = $attr;
            break;
        } else if ($attr instanceof SpecialRoute) {
            $is_special_route = true;
            if ($attr->id == "404") {
                $spr_404 = Closure::fromCallable([MainRouter::class, $m->name]);
            } else {
                throw new Exception(sprintf("unknown special route id \"%s\" in MainRouter, method \"%s\"", $attr->id, $m->name));
            }
        }
    }
    if ($is_special_route) continue;

    if (is_null($route))
        throw new Exception(sprintf("routeless method \"%s\" in MainRouter", $m->name));
    $routes[$route->path] = Closure::fromCallable([MainRouter::class, $m->name]);
}
if (is_null($spr_404)) {
    throw new Exception("required special route \"404\" not specified");
}

$wanted_route = $routes[$request] ?? null;
$response = ($wanted_route ?? $spr_404)();
http_response_code($response->code);
echo $response->body;
