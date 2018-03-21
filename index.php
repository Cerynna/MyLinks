<?php
$loader = require __DIR__ . '/vendor/autoload.php';
$base = new Entity\Base();
$path = $_GET["route"];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header('Content-Type: application/json');
    switch ($path) {
        case"filtres":

            $url = "&tags=" . implode('-', $_POST['tags']);
            header('Location: ?route=listLinks' . $url);
            break;
        case"getLinks":
            echo json_encode($base->getListLinks($_POST['offset']));
            return true;
            break;
        case"addBadWord":
            $base->addBadWord($_POST["links"], $_POST["tag"]);
            return true;
            break;
        case"addTagToLink":
            $base->addTagToLink($_POST["slug"], $_POST["tag"]);
            return true;
            break;
        case"deleteTagToLink":
            $base->deleteTagToLink($_POST["slug"], $_POST["tag"]);
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
            $base->updateLink($_POST["slug"], $_POST["data"]);
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

    $jsActive = false;
    switch ($path) {
        case "listLinks":
        case null:
        case "":

            $listLinks = $base->getListLinks(0, null, $_GET['tags']);
            $listTags = $base->getListTags();
            include('views/listLinks.php');
            $jsActive = true;
            $path = "listLinks";
            break;
        case "newLink":
            include('views/newLink.php');
            break;

        case "listTags":
            $listTags = $base->getListTags();
            include('views/listTags.php');
            $jsActive = true;
            break;
        case "toDo":
            include('views/toDo.php');
            break;

    }
    include("views/partials/script.php");
    if ($jsActive === true) {
        if ($_SERVER['SERVER_NAME'] === '127.0.0.1') {
            $js = file_get_contents("public/js/$path.js");
            $minifiedCode = \JShrink\Minifier::minify($js);
            file_put_contents("public/js/$path.min.js", $minifiedCode);
            echo "<script src=\"public/js/$path.js\"></script>";
        } else {
            echo "<script src=\"public/js/$path.min.js\"></script>";
        }

    }

    include("views/partials/footer.php");
}



