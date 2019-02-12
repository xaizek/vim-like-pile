<div class="categoryLinks">
    <?php foreach ($categories as $category => $items): ?>
    <div class="categoryLink">
        <a href="#<?php echo call_user_func($makeHeaderId, $category) ?>">
            <?php echo $category; ?>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<?php foreach ($categories as $category => $items): ?>
<div class="category"
     id="<?php echo call_user_func($makeHeaderId, $category) ?>">
    <?php echo $category; ?>
</div>
<div class="islands">
    <?php
    $tiles = new Template('tiles', $parent);
    $tiles->items = $items;
    echo $tiles->format();
    ?>
</div>
<?php endforeach; ?>
