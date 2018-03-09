<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$base = new Entity\Base();
$path = $_GET["route"];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header('Content-Type: application/json');
    switch ($path) {
        case"addBadWord":
            $base->addBadWord($_POST["name"], $_POST["links"]);
            return true;
            break;
        case"addTagToLink":
            $base->addTagToLink($_POST["slug"], $_POST["tag"]);
            return true;
            break;
        case "addLink":
            if (filter_var($_POST["link"], FILTER_VALIDATE_URL)) {
                $link = new Entity\Link($_POST["link"]);
                $arrayLink = $link->getArray();
                $add = $base->addLink($arrayLink, $arrayLink['slug']);
                if ($add === true) {
                    $base->addTags($arrayLink['tags'], $arrayLink['slug']);
                }
            }
            header('Location: ?route=listLinks');
            break;
        case "updateLink":
            $base->updateLink($_POST["slug"],$_POST["data"]);
            break;
        case "deleteLink":
            $base->deleteLink($_POST["slug"]);
            break;
        case "addClick":
            $base->addClick($_POST["slug"]);
            break;
    }
} else {
    include("views/partials/head.php");
    include("views/partials/menu.php");


    switch ($path) {
        case "listLinks":
        case null:
        case "":
            $listLinks = $base->getListLinks();
            $listTags = $base->getListTags();
            include('views/listLinks.php');
            break;
        case "newLink":
            include('views/newLink.php');
            break;

        case "listTags":
            $listTags = $base->getListTags();
            include('views/listTags.php');
            break;
        case "toDo":
            include('views/toDo.php');
            break;


    }


    include("views/partials/footer.php");
}



