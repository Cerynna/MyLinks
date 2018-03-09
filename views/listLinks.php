<?php
/**
 * Created by PhpStorm.
 * User: cerynna
 * Date: 08/03/18
 * Time: 00:10
 */

?>

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
            LES FILTRES BIENTOT
        </div>
        <div class="col-4">
            <div class="nbLinks">
                <span id="nbLinks">0</span> Links
            </div>
        </div>
    </div>
    <div class="row">
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
                             data-link="<?php echo $link["link"]; ?>"><?php echo $link["meta"]["description"]; ?></div>
                        <div class="tags">
                            <div class="push"></div>
                            <?php
                            foreach ($link["tags"] as $tag) {
                                ?>
                                <span class="tag"><?php echo $tag; ?></span>
                                <?php
                            }
                            ?>

                        </div>
                        <div class="tools">
                            <div class="button deleteLink"
                                 data-link="<?php echo $link["slug"]; ?>">
                                <i class="fas fa-trash-alt icons"></i>
                            </div>
                            <!--
                            Pouvoir changer la miniature soit via API google pour le screen
                            Soit utilisé Croppie avec image perso
                            <i class="fas fa-image icons"></i>-->
                            <div class="button addTag"
                                 data-link="<?php echo $link["slug"]; ?>"
                                 data-name="<?php echo $link["nom"]; ?>">
                                <i class="fas fa-plus-square icons"></i>
                            </div>
                            <div class="button editLink"
                                 data-link="link_<?php echo $i; ?>"
                                 data-slug="<?php echo $link["slug"]; ?>">
                                <i class="fas fa-pen-square icons"></i>
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
<script>
    $(document).ready(function () {

        $('#nbLinks').animateNumber(
            {
                number: <?php echo count($listLinks); ?>,
                color: 'green',
                'font-size': '30px',

                easing: 'easeInQuad',

            },
            3000
        );
        const modalTag = $('#modalTag');
        const modalEdit = $('#modalEdit');
        const allModal = $('.modal');
        const closeModal = $('.closeModal');

        scrollTags();

        $('.click').mouseover(function (callback) {
            $('#' + $(this).data('share')).fadeIn("fast");
        });
        $('.share').mouseleave(function (callback) {
            $(this).fadeOut("fast");
        }).mouseenter(function (callback) {
            $(this).fadeIn("fast");
        });
        $('.myLink').click(function (callback) {
            console.log($(this));
            const slugLink = $(this).data('slug');
            AjaxAddClick(slugLink);
            window.open($(this).data('link'), '_blank');
        });
        $('.myLinkPopup').click(function (callback) {
            console.log("TU CLICK");
            const size = $(this).data('size').split(',');
            MyLinkPopup($(this).data('link'), size, $(this).data('name'))
        });


        $('.addTag').click(function (callback) {
            $('.submitTag').attr('data-link', $(this).data('link'));
            modalTag.fadeIn();
            $('body').addClass('modal-open');
        });
        $('.editLink').click(function (callback) {
            const inputTitleLink = $('#titleLink');
            const inputDescLink = $('#descLink');
            const title = $('#' + $(this).data('link') + ' .name').text();
            const desc = $('#' + $(this).data('link') + ' .desc').text();
            $('.submitEdit').attr('data-link', $(this).data('slug'));
            inputTitleLink.val(title);
            inputDescLink.val(desc);
            modalEdit.fadeIn();
            $('body').addClass('modal-open');
        });
        $(document).keyup(function (e) {
            if (e.keyCode === 27) {
                closeModal.click();
            }
        });
        closeModal.click(function (calllback) {
            allModal.fadeOut();
            $('body').removeClass('modal-open');
        });
        $('.submitEdit').click(function (callback) {
            const inputTitleLink = $('#titleLink');
            const inputDescLink = $('#descLink');
            const slugLink = $(this).data('link');
            const data = {
                "title": inputTitleLink.val(),
                "desc": inputDescLink.val()
            };

            AjaxUpdateLink(slugLink, data);
            location.reload();

        });

        $('.submitTag').click(function (calllback) {
            const inputValue = $('#newTag').val();
            const slugLink = $(this).data('link');
            if (inputValue !== "") {
                console.log("NEW TAG");
                AjaxUrl(slugLink, inputValue);

            }
            location.reload();

        });

        $('.deleteLink').click(function (callback) {
            console.log("delete link");
            const slugLink = $(this).data('link');
            AjaxDelteLink(slugLink);
            location.reload();
        })

    });

    /* $('.content').hover(function (callback) {
         const idDiv = $(this)[0].id;
         $("#" + idDiv + " .tags").animate({
             scrollTop: 0
         });
         scrollTags();
     })*/

    function MyLinkPopup(url, size, name) {
        width = size[0];
        height = size[1];
        if (window.innerWidth) {
            var left = (window.innerWidth - width) / 2;
            var top = (window.innerHeight - height) / 2;
        }
        else {
            var left = (document.body.clientWidth - width) / 2;
            var top = (document.body.clientHeight - height) / 2;
        }
        window.open(url, name, 'menubar=no, scrollbars=no, top=' + top + ', left=' + left + ', width=' + width + ', height=' + height + '');
    }


    function scrollTags() {
        $('.tags').stop().animate({
            scrollTop: 500
        }, 10000);
    }

    function AjaxUrl(slug, tag) {
        return $.ajax({
            type: 'POST',
            url: "?route=addTagToLink",
            dataType: 'json',
            timeout: 5000,
            data: {
                slug: slug,
                tag: tag
            },
            success: function (response) {
                return response
            },
            error: function () {
                return "Erreur"
            }
        })
    }

    function AjaxAddClick(slug) {
        return $.ajax({
            type: 'POST',
            url: "?route=addClick",
            dataType: 'json',
            timeout: 5000,
            data: {
                slug: slug
            }
        })
    }

    function AjaxDelteLink(slug) {
        return $.ajax({
            type: 'POST',
            url: "?route=deleteLink",
            dataType: 'json',
            timeout: 5000,
            data: {
                slug: slug,
            },
            success: function (response) {
                return response
            },
            error: function () {
                return "Erreur"
            }
        })
    }

    function AjaxUpdateLink(slug, data) {
        return $.ajax({
            type: 'POST',
            url: "?route=updateLink",
            dataType: 'json',
            timeout: 5000,
            data: {
                slug: slug,
                data: data
            },
            success: function (response) {
                return response
            },
            error: function () {
                return "Erreur"
            }
        })
    }
</script>
