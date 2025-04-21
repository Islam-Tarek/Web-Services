<?php

class RequestHandler
{


    // localhost:8000/items/id

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getResource()
    {
        $url = $_SERVER['REQUEST_URI'];
        $urlParts = explode("/", $url);
        // print_r($urlParts);
        return $urlParts[0] ?: null;
    }

    public function getResourceId()
    {
        $url = $_SERVER['REQUEST_URI'];
        $urlParts = explode("/", $url);
        // print_r($urlParts);
        return $urlParts[2] ?: null;
    }
}
