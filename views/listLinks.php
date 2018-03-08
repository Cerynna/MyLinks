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
            <div class="title"></div>
            <div class="form">
                <input type="text" id="newTag" name="newTag">
                <select name="currentTag" id="currentTag">
                    <option value="null"></option>
                    <?php
                    $i = 0;
                    foreach ($listTags as $tag) {
                        ?>
                        <option value="<?php echo $tag["name"]; ?>"><?php echo $tag["name"]; ?></option>
                        <?php
                        $i++;
                    }
                    ?>
                </select>
                <div class="submitTag" data-link=""><i class="fas fa-check-square icons"></i></div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalEdit">
        <div class="contentModal">
            <div class="closeModal text-right"><i class="fas fa-times-circle icons-mini"></i></div>

            <input type="text" name="titleLink" id="titleLink" value="title">
            <textarea name="descLink" id="descLink">desc</textarea>

            <div class="submitEdit" data-link=""><i class="fas fa-check-square icons"></i></div>
        </div>
    </div>
    <div class="row">

        <?php
        $i = 0;
        foreach ($listLinks as $link) {

            ?>

            <div class="col-4 ">
                <div class="myCard"
                     style="background-size: cover;
                             background: #FFF url('<?php echo $link["meta"]["image"]; ?>') center no-repeat;">
                    <div class="content" id="link_<?php echo $i; ?>">
                        <div class="name"><?php echo $link["nom"]; ?></div>
                        <div class="desc myLink"
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
                            <i class="fas fa-image icons"></i>
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

        const modalTag = $('#modalTag');
        const modalEdit = $('#modalEdit');
        const allModal = $('.modal');
        const closeModal = $('.closeModal');

        scrollTags();

        $('.myLink').click(function (callback) {
            window.open($(this).data('link'), '_blank')
        });
        $('.addTag').click(function (callback) {
            $('.submitTag').attr('data-link', $(this).data('link'));
            modalTag.fadeIn();
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
        });
        $(document).keyup(function (e) {
            if (e.keyCode === 27) {
                closeModal.click();
            }
        });
        closeModal.click(function (calllback) {
            allModal.fadeOut();
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
            const selectValue = $('#currentTag option:selected').val();
            const inputValue = $('#newTag').val();
            const slugLink = $(this).data('link');
            if (selectValue === "null") {
                console.log("NEW TAG");
                AjaxUrl(slugLink, inputValue);

            } else {
                console.log("Current TAG");
                AjaxUrl(slugLink, selectValue);
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

    $('.content').hover(function (callback) {
        const idDiv = $(this)[0].id;
        $("#" + idDiv + " .tags").animate({
            scrollTop: 0
        });
        scrollTags();
    })

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
