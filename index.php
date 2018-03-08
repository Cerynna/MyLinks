<?php

$loader = require __DIR__ . '/vendor/autoload.php';


include("views/partials/head.php");
include("views/partials/menu.php");



$base = new Entity\Base();


/*$path = $_GET["route"];*/
$path = $_SERVER['PATH_INFO'];

switch ($path) {
    case "/":
    case "/home":
    case null:
        include('views/home.php');
        break;
    case "/add":
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $link = new Entity\Link($_POST["link"]);
            $arrayLink = $link->getArray();
            $add = $base->addLink($arrayLink, $arrayLink['slug']);
            $base->addTags($arrayLink['tags']);
            header('Location: /listLinks');
        }
        break;
    case "/listLinks":
        $listLinks = $base->getListLinks();
        include('views/listLinks.php');
        break;
}


include("views/partials/footer.php");

