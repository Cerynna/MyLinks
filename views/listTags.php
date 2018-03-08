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

        usort($listTags, function($a, $b) {
            return $a['nb'] <=> $b['nb'];
        });
        $listTags = array_reverse($listTags);
        foreach ($listTags as $tag) {
            ?>
            <span class="tag"><?php echo $tag["name"]; ?> <i class="nb"><?php echo $tag["nb"]; ?></i></span>

            <?php
            $i++;
        }
        ?>
    </div>
</div>
<script>


</script>
