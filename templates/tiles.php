<div class="islands">

<?php foreach ($items as $item): ?>
    <div class="island">
        <div class="name">
            <a href="<?php echo $item->url; ?>"><?php echo $item->name; ?></a>
        </div>

        <div class="descr"><?php echo $item->descr; ?></div>
    </div>
<?php endforeach; ?>

</div>
