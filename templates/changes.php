<div class="centerBox">

<div class="name">Latest changes of the list</div>

<ul>
  <li>The ordering is from newest to oldest.</li>
  <li>Only last update is tracked.</li>
  <li>Items with a corresponding entry in this log that's newer than 6 months
      get <span class="label">new</span> and/or
      <span class="label">updated</span> labels.</li>
</ul>

<ol>
<?php $last_date = ''; ?>
<?php foreach ($items as $date => $item): ?>
    <?php
        $date_str = date('Y.m.d', $date);
        if ($last_date != $date_str) {
            echo "<div class=\"changeDate\">$date_str</div>";
            $last_date = $date_str;
        }
    ?>

    <li class="change">
        <b><a href="<?php echo $webRoot; ?>/item/<?php echo $item->id; ?>"><?php echo $item->name; ?></a></b>
        <?php
            if (isset($item->added) && $date == $item->added) {
                echo "<b>(added)</b><br/>";
            }
            if (isset($item->updated) && $date == $item->updated) {
                echo "<b>(updated)</b><br/>";
            }
        ?>
        <?php echo $item->descr; ?>
    </li>

<?php endforeach; ?>
</ol>

</div>
