<?php
/**
 * Created by PhpStorm.
 * User: cerynna
 * Date: 08/03/18
 * Time: 00:10
 */

?>

<div class="main container">
    <div class="row">
        <?php
        $i = 0;
        foreach ($listTags as $name => $tag) {
            ?>
            <span class="tag">
                <div class="addBadWord"
                     data-name="<?php echo $tag["name"]; ?>"
                     data-links="<?php echo implode(',', $tag["links"]); ?>">
                    <i class="fas fa-times-circle icons-mini"></i>
                </div>
                <?php echo $tag["name"]; ?>
                <i class="nb"><?php echo $tag["nb"]; ?></i>
            </span>
            <?php
            $i++;
        }
        ?>
    </div>
</div>
<script>



</script>
