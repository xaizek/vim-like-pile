<?php foreach ($categories as $category => $items): ?>
<div class="category">
    <?php echo $category; ?> (<?php echo sizeof($items); ?>)
</div>
<div class="islands">
    <?php
    $tiles = new Template('tiles');
    $tiles->items = $items;
    echo $tiles->format();
    ?>
</div>
<?php endforeach; ?>
