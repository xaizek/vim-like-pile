<?php foreach ($items as $item): ?>
    <div class="island">
        <div class="name">
            <a href="<?php echo $webRoot; ?>/item/<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
        </div>

        <div class="descr"><?php echo $item->descr; ?></div>

        <?php
            global $db_label_cutoff;
            if (isset($item->state)) {
                $state_label = get_state_label($item);
                echo "<span class=\"label\">$state_label</span>";
            }
            if (isset($item->added) && $item->added > $db_label_cutoff) {
                echo '<span class="label">added</span>';
            }
            if (isset($item->updated) && $item->updated > $db_label_cutoff) {
                echo '<span class="label">updated</span>';
            }
        ?>
    </div>
<?php endforeach; ?>
