<html>

<head>
    <title><?php echo $title; ?></title>
    <link href="<?php echo $webRoot; ?>/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <h1><?php echo $title; ?></h1>
    <div class="types">
        <span class="type <?php if ($type == 'apps') echo 'currentType'; ?>">
            <a href="<?php echo $webRoot; ?>/apps">Applications</a></span>
        <span class="type <?php if ($type == 'plugs') echo 'currentType'; ?>">
            <a href="<?php echo $webRoot; ?>/plugs">Plugins</a></span>
        <span class="type <?php if ($type == 'confs') echo 'currentType'; ?>">
            <a href="<?php echo $webRoot; ?>/confs">Configurations</a></span>
    </div>
    <div class="typeDescr">
        <?php echo $descr; ?>
    </div>
    <div>
        <?php echo $content; ?>
    </div>
</body>

</html>
