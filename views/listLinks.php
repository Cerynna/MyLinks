<?php
/**
 * Created by PhpStorm.
 * User: cerynna
 * Date: 08/03/18
 * Time: 00:10
 */

?>
<pre>
    <?php
    //print_r($listTags);
    ?>
</pre>

<div class="main container">
    <div class="modal" id="modalTag">
        <div class="contentModal">
            <div class="closeModal text-right"><i class="fas fa-times-circle icons-mini"></i></div>
            <div class="title">Ajouter un Tag</div>
            <div class="form">
                <input type="text" id="newTag" name="newTag">
                <div class="submit submitTag" data-link="">Valider</div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalEdit">
        <div class="contentModal">
            <div class="closeModal text-right"><i class="fas fa-times-circle icons-mini"></i></div>
            <div class="title">Editer un Link</div>
            <div class="form">
                <input type="text" name="titleLink" id="titleLink" value="title">
                <textarea name="descLink" id="descLink">desc</textarea>
            </div>
            <div class="submit submitEdit" data-link="">Valider</div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <form method="post" action="?route=filtres" name="filtres" id="filtres">
                <div class="refresh"><a href="?route=listLink"><i class="fas fa-sync-alt"></i></a>  </div>
                <label for="tags">Tags</label>
                <select name="tags[]" id="tag" multiple>
                    <?php foreach ($listTags as $key => $tag): ?>
                    <option value="<?php echo $tag["name"]; ?>"><?php echo $tag["name"]; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="submit"><i class="fas fa-check"></i></div>
            </form>
        </div>
        <div class="col-4">
            <div class="nbLinks">
                <span id="nbLinks">0</span> Links
            </div>
        </div>
    </div>
    <div class="row" id="listLinks">
        <?php
        $i = 0;
        foreach ($listLinks as $link) {
            ?>
            <div class="col col-md-4 col-xs-1">
                <div class="myCard"
                     style="background-size: cover;
                             background: #FFF url('<?php echo $link["meta"]["image"]; ?>') center no-repeat;">
                    <div class="content" id="link_<?php echo $i; ?>">
                        <div class="click" data-share="share_<?php echo $i; ?>">
                            <?php echo (!isset($link["click"])) ? '0' : $link["click"]; ?>
                        </div>
                        <div class="share" id="share_<?php echo $i; ?>">
                            <div class="share_link myLinkPopup"
                                 data-size="580,680"
                                 data-name="Share Facebook"
                                 data-link="https://www.facebook.com/sharer/sharer.php?u=<?php echo utf8_encode($link["link"]); ?>">
                                <i class="fab fa-facebook-square icons"></i>
                            </div>
                            <div class="share_link myLinkPopup"
                                 data-size="580,300"
                                 data-name="Share Twitter"
                                 data-link="https://twitter.com/home?status=<?php echo utf8_encode($link["link"]); ?>">
                                <i class="fab fa-twitter-square icons"></i>
                            </div>
                            <div class="share_link myLinkPopup"
                                 data-size="580,530"
                                 data-name="Share Linkedin"
                                 data-link="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo utf8_encode($link["link"]); ?>&title=<?php echo $link["nom"]; ?>&summary=&source=">
                                <i class="fab fa-linkedin icons "></i>
                            </div>
                        </div>
                        <div class="name"><?php echo $link["nom"]; ?></div>
                        <div class="desc myLink"
                             data-slug="<?php echo $link["slug"]; ?>"
                             data-link="<?php echo $link["link"]; ?>">
                            <?php echo $link["meta"]["description"]; ?>
                        </div>
                        <div class="tags">
                            <div class="push"></div>
                            <?php
                            foreach ($link["tags"] as $tag) {
                                ?>
                                <span class="tag">
                                    <div class="deleteTagToLink hidden"
                                         data-tag="<?php echo $tag["name"]; ?>"
                                         data-slug="<?php echo $link["link"]; ?>">
                                            <i class="fas fa-times-circle icons-mini"></i>
                                    </div>
                                    <?php echo $tag; ?>
                                </span>
                                <?php
                            }
                            ?>

                        </div>
                        <div class="tools">
                            <div class="row">
                                <div class="col button changeView"
                                     data-link="link_<?php echo $i; ?>">
                                    <i class="fas fa-tags icons"></i>
                                </div>
                                <div class="col button addTag"
                                     data-link="<?php echo $link["slug"]; ?>"
                                     data-name="<?php echo $link["nom"]; ?>">
                                    <i class="fas fa-plus-square icons"></i>
                                </div>
                                <div class="col">

                                </div>

                                <!--
                                Pouvoir changer la miniature soit via API google pour le screen
                                Soit utilisé Croppie avec image perso
                                <i class="fas fa-image icons"></i>-->

                                <div class="col button editLink"
                                     data-link="link_<?php echo $i; ?>"
                                     data-slug="<?php echo $link["slug"]; ?>">
                                    <i class="fas fa-pen-square icons"></i>
                                </div>
                                <div class="col button deleteLink"
                                     data-link="<?php echo $link["slug"]; ?>">
                                    <i class="fas fa-trash-alt icons"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php
            $i++;
        }
        ?>
    </div>
</div>

