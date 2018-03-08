<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('', __DIR__);


include("views/partials/head.php");
include("views/partials/menu.php");




/*var_dump($_SERVER);*/

/*require_once(__DIR__. 'Entity/Base.php');
require_once(__DIR__. 'Entity/Link.php');*/

$base = new Entity\Base();


$path = $_GET["route"];
echo $path;
/*
 * file_put_contents("base.json", json_encode($arrayPush));
 * {"nom":"test","link":"","meta":"","tag":["php","js","ect"]}
 */
switch ($path) {
    case "":
    case "home":
    case null:
        include('views/home.php');
        break;
    case "add":
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $link = new Link($_POST["link"]);
            $arrayLink = $link->getArray();
            $add = $base->addLink($arrayLink, $arrayLink['slug']);
            $base->addTags($arrayLink['tags']);
            header('Location: /listLinks');
        }
        break;
    case "listLinks":
        $listLinks = $base->getListLinks();
        include('views/listLinks.php');
        break;
}


include("views/partials/footer.php");

