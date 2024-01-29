<?php

namespace controller;
use \Response;
use \SpecialRoute;
use \Route;

class MainRouter {
    use Index;

    #[Route("/hello")]
    static function m1(): Response {
        return null;
    }

    #[Route("/foo")]
    static function m2(): Response {
        return null;
    }

    #[SpecialRoute("404")]
    static function notFound(): Response {
        return new Response(
            body: "<h1>Oops!</h1><p>The page you requested does not exist.</p>",
            code: 404,
        );
    }
}
