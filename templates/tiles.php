<?php foreach ($items as $item): ?>
    <div class="island">
        <div class="name">
            <a href="<?php echo $webRoot; ?>/item/<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
        </div>

        <div class="descr"><?php echo $item->descr; ?></div>
    </div>
<?php endforeach; ?>
