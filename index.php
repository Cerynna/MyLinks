<?php
// Désactiver le rapport d'erreurs
error_reporting(0);

// Rapporte les erreurs d'exécution de script
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Rapporter les E_NOTICE peut vous aider à améliorer vos scripts
// (variables non initialisées, variables mal orthographiées..)
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// Rapporte toutes les erreurs à part les E_NOTICE
// C'est la configuration par défaut de php.ini
error_reporting(E_ALL & ~E_NOTICE);

// Reporte toutes les erreurs PHP (Voir l'historique des modifications)
error_reporting(E_ALL);

// Reporte toutes les erreurs PHP
error_reporting(-1);

// Même chose que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

include("views/partials/head.php");
include("views/partials/menu.php");


/*var_dump($_SERVER);*/

require('Entity/Base.php');
require('Entity/Link.php');

$base = new Base();




$path = $_GET["route"];
echo $path;
/*
 * file_put_contents("base.json", json_encode($arrayPush));
 * {"nom":"test","link":"","meta":"","tag":["php","js","ect"]}
 */
/*switch ($path) {
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

}*/


include("views/partials/footer.php");

