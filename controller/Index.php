<?php

namespace controller;
use \Route;
use \Response;
use \view\

trait Index {
    #[Route("/")]
    static function index(): Response {
        return new Response(
            body: new HtmlView(),
        );
    }
}
