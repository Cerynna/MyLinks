<?php
/**
 * Created by PhpStorm.
 * User: cerynna
 * Date: 08/03/18
 * Time: 00:10
 */

?>

<div class="main container-fluid">
    <div class="row">

        <?php
        $i = 0;
        foreach ($listLinks as $link) {
            ?>

            <div class="col-3 myLink" data-link="<?php echo $link["link"]; ?>">
                <div class="myCard"
                     style="background-size: cover; background: #FFF url('<?php echo $link["meta"]["image"]; ?>') center no-repeat;">
                    <div class="content" id="link_<?php echo $i; ?>">
                        <div class="name"><?php echo $link["meta"]["title"]; ?></div>
                        <div class="desc"><?php echo $link["meta"]["description"]; ?></div>
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
        scrollTags();
        $('.myLink').click(function (callback) {
            window.open($(this).data('link'), '_blank')
        });

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


</script>