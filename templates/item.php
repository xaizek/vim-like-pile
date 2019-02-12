<div class="info">
    <div class="name">
        <a href=""><?php echo $item->name; ?></a>
    </div>

    <div class="descr"><?php echo $item->descr; ?></div>

    <div class="infoItem">
        <span class="infoKey">License</span>
        <span class="infoValue">
            <?php echo $item->license; ?>
        </span>
    </div>

    <div class="infoItem">
        <span class="infoKey">Languages</span>
        <span class="infoValue">
            <?php echo implode(', ', $item->languages); ?>
        </span>
    </div>

    <div class="infoItem">
        <span class="infoKey">UI</span>
        <span class="infoValue">
            <?php echo $item->ui; ?>
        </span>
    </div>

    <div class="infoItem">
        <span class="infoKey">Category</span>
        <span class="infoValue">
            <?php echo $item->category; ?>
        </span>
    </div>

    <div class="infoItem">
        <span class="infoKey">URL</span>
        <span class="infoValue">
            <a href="<?php echo $item->url; ?>"><?php echo $item->url; ?></a>
        </span>
    </div>

    <?php if (!empty($item->comments)): ?>
    <div class="infoItem">
        <span class="infoKey">Notes</span>
        <ul>
        <?php foreach ($item->comments as $comment): ?>
        <li class="comment">
            <?php echo $comment; ?>
        </li>
        <?php endforeach ?>
        </ul>
    </div>
    <?php endif ?>
</div>

<div class="completeCategory">
    <?php echo "All items of $item->category category"; ?>
</div>
<div class="islands">
    <?php
    $tiles = new Template('tiles', $parent);
    $tiles->items = $category;
    echo $tiles->format();
    ?>
</div>
