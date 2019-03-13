<div class="search">

<div class="name">Search</div>

<div class="search-info">
The search is over names and descriptions of all items.
</div>

<form action="<?php echo $webRoot; ?>/search" method="get">
<input type="search" name="q" value="<?php echo $query ?>" autofocus required/>
<div class="submit"><input type="submit" value="Find"/></div>
</form>

</div>

<div class="islands">
    <?php
    $tiles = new Template('tiles', $parent);
    $tiles->items = $matches;
    echo $tiles->format();
    ?>
</div>
