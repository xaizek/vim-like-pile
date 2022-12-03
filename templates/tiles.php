<?php

$six_months_secs = 60*60*24*30*6;
$cutoff_date = time() - $six_months_secs;

?>

<?php foreach ($items as $item): ?>
    <div class="island">
        <div class="name">
            <a href="<?php echo $webRoot; ?>/item/<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
        </div>

        <div class="descr"><?php echo $item->descr; ?></div>

        <?php
            if (isset($item->added) && $item->added > $cutoff_date) {
                echo '<span class="label">new</span>';
            }
            if (isset($item->updated) && $item->updated > $cutoff_date) {
                echo '<span class="label">changed</span>';
            }
        ?>
    </div>
<?php endforeach; ?>
